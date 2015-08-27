<?php
namespace Url2png\Tasks;

use Phalcon\Cli\Task;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Formatter\Json;
use Url2png\Libs\PhantomJs\PhantomJsClient;
use Url2png\Models\ScreenCaptures;

class CaptureTask extends Task
{
    public function processAction()
    {
        /* @var $job \Phalcon\Queue\Beanstalk\Job */
        while (($job = $this->queue->reserve())) {
            $message = json_decode($job->getBody(), true);
            $uuid = $message['uuid'];
            $params = array_merge([
                'url' => '',
                'viewportWidth' => 0,
                'viewportHeight' => 0,
                'rectTop' => 0,
                'rectLeft' => 0,
                'rectWidth' => 0,
                'rectHeight' => 0,
                'data' => null,
                'delay' => 2,
                'file' => APP_PATH . DS . 'cache' . DS . $uuid . DS . $uuid . '.png',
                'cookie' => APP_PATH . DS . 'cache' . DS . $uuid . DS . $uuid . '.cookie',
            ], $message['payload']);

            // if validation of params failed then there will be validation messages
            if ($this->validation->validate($params)->count()) {
                $this->logger->error(sprintf('Validation of %s failed.', $uuid));
                $job->delete();
                continue;
            }

            // create subfolder for storing all info
            if (!is_dir(APP_PATH . DS . 'cache' . DS . $uuid) && !mkdir(APP_PATH . DS . 'cache' . DS . $uuid, 0777,
                    true)
            ) {
                $this->logger->error(sprintf('Creation of folder %s failed.', $uuid));
                $job->release();
                continue;
            }

            try {
                $phantomjs = new PhantomJsClient($uuid, $params, (new FileLogger(APP_PATH.DS.'logs'.DS.'app.log'))->setFormatter(new Json()));
                $phantomjs->capture();
                $job->delete();

                /* @var $screencapture \Url2png\Models\ScreenCaptures */
                $screencapture = ScreenCaptures::findFirstByUuid($uuid);
                $screencapture->processed = 1;
                $screencapture->update();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $job->release();
            }
        }
    }

    public function reloadAction()
    {
        $failed = [];
        $screencaptures = new ScreenCaptures();
        $captures = $screencaptures->find([
            'columns' => ['uuid', 'params'],
            'conditions' => 'processed = :processed:',
            'bind' => ['processed' => 0],
        ]);

        foreach ($captures as $capture) {
            if (!$this->queue->put(json_encode([
                'uuid' => $capture->uuid,
                'payload' => json_decode($capture->params)
            ]))
            ) {
                $failed[] = $capture->uuid;
            }
        }

        if ($failed) {
            throw new \RuntimeException(sprintf('Failed to queue jobs: %s', implode(', ', $failed)));
        }
    }
}