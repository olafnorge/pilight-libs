<?php
namespace Pilight;

/**
 * Class AbstractSubscriber
 * @package Pilight
 */
abstract class AbstractSubscriber extends AbstractClient
{
    protected $filters = [];

    /**
     * Attaches to socket and reads messages from it
     * @param $callbacks string|array any valid callback that can be passed to 'call_user_func'
     * @throws \Exception
     */
    final public function listen($callbacks)
    {
        $buffer = '';

        do {
            $buffer .= fgets($this->getSocket(), 1024);
            $length = strlen($buffer);

            if ($length > 2 && 10 === ord($buffer[$length - 1]) && 10 === ord($buffer[$length - 2])) {
                $message = json_decode(trim(substr($buffer, 0, -2)), true);

                if (isset($message['origin']) && (empty($this->filters) || in_array($message['origin'], $this->filters))) {
                    $this->callback($callbacks, $message);
                }

                $buffer = '';
            }
        } while ($this->isAlive());

        throw new \Exception('Connection to host lost.');
    }
}