<?php
namespace Url2png\Tasks;


use Phalcon\Cli\Task;
use Phalcon\Script\Color;
use Phalcon\Security;
use Rhumsaa\Uuid\Uuid;
use Url2png\Models\Users;

class UserTask extends Task
{

    public function createAction(array $params)
    {
        if (empty($params[0])) {
            throw new \InvalidArgumentException('Missing username');
        }

        $username = $params[0];
        /* @var $user \Url2png\Models\Users */
        $user = Users::findFirstByUsername($username);

        if (!$user) {
            $user = new Users();
            $security = new Security();
            $hash = $security->hash($username, 12);
            $apikey = Uuid::uuid5(Uuid::NAMESPACE_DNS, $hash)->toString();
        } else {
            $apikey = $user->apikey;
        }

        $user->username = $username;
        $user->apikey = $apikey;
        $user->deleted = 0;
        $success = $user->save();

        if ($success) {
            echo Color::success(sprintf('The api key for %s is %s', $username, $apikey)) . PHP_EOL;
            return;
        }

        echo Color::error(sprintf('User %s couldn\'t be created. The following problems were generated:', $username)) . PHP_EOL;

        foreach ($user->getMessages() as $message) {
            echo Color::error($message->getMessage()) . PHP_EOL;
        }
    }

    public function deleteAction(array $params)
    {
        if (empty($params[0])) {
            throw new \InvalidArgumentException('Missing username');
        }

        $username = $params[0];
        /* @var $user \Url2png\Models\Users */
        $user = Users::findFirstByUsername($username);
        $user->deleted = 1;
        $success = $user->update();

        if ($success) {
            echo Color::success(sprintf('User %s deleted', $username)) . PHP_EOL;
            return;
        }

        echo Color::error(sprintf('User %s couldn\'t be deleted. The following problems were generated:', $username)) . PHP_EOL;

        foreach ($user->getMessages() as $message) {
            echo Color::error($message->getMessage()) . PHP_EOL;
        }
    }

    public function resetAction(array $params)
    {
        if (empty($params[0])) {
            throw new \InvalidArgumentException('Missing username');
        }

        $username = $params[0];
        /* @var $user \Url2png\Models\Users */
        $user = Users::findFirstByUsername($username);

        if (!$user) {
            echo Color::error(sprintf('User %s couldn\'t be reset. User was not found.', $username)) . PHP_EOL;
            return;
        }

        $security = new Security();
        $hash = $security->hash($username, 12);
        $apikey = Uuid::uuid5(Uuid::NAMESPACE_DNS, $hash)->toString();

        $user->username = $username;
        $user->apikey = $apikey;
        $user->deleted = 0;
        $success = $user->save();

        if ($success) {
            echo Color::success(sprintf('The api key for %s is %s', $username, $apikey)) . PHP_EOL;
            return;
        }

        echo Color::error(sprintf('User %s couldn\'t be created. The following problems were generated:', $username)) . PHP_EOL;

        foreach ($user->getMessages() as $message) {
            echo Color::error($message->getMessage()) . PHP_EOL;
        }
    }
}