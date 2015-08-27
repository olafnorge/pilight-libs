<?php
namespace Pilight\Cli\Tasks;

use Phalcon\Cli\Task;
use Pilight\Host;
use Pilight\Subscriber\Config;

/**
 * @property Host Host
 */
class ConfigTask extends Task
{

    public function mainAction()
    {
        $Subscriber = new Config($this->Host);
        $Subscriber->listen('print_r');
    }
}