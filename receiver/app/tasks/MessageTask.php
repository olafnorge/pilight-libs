<?php
namespace Pilight\Cli\Tasks;

use Phalcon\Cli\Task;
use Pilight\Host;
use Pilight\Subscriber\Message;

/**
 * @property Host Host
 */
class MessageTask extends Task
{

    public function mainAction()
    {
        $Subscriber = new Message($this->Host);
        $Subscriber->listen('print_r');
    }
}