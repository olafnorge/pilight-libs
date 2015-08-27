<?php
namespace Pilight\Cli\Tasks;

use Phalcon\Cli\Task;
use Pilight\Host;
use Pilight\Subscriber\Core;

/**
 * @property Host Host
 */
class CoreTask extends Task
{

    public function mainAction()
    {
        $Subscriber = new Core($this->Host);
        $Subscriber->listen('print_r');
    }
}