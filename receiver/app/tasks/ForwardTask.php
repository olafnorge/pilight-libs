<?php
namespace Pilight\Cli\Tasks;

use Phalcon\Cli\Task;
use Pilight\Host;
use Pilight\Subscriber\Forward;

/**
 * @property Host Host
 */
class ForwardTask extends Task
{

    public function mainAction()
    {
        $Subscriber = new Forward($this->Host);
        $Subscriber->listen('print_r');
    }
}