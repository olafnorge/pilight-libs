<?php
namespace Pilight\Cli\Tasks;

use Phalcon\Cli\Task;
use Pilight\Host;
use Pilight\Subscriber\Stats;

/**
 * @property Host Host
 */
class StatsTask extends Task
{

    public function mainAction()
    {
        $Subscriber = new Stats($this->Host);
        $Subscriber->listen('print_r');
    }
}