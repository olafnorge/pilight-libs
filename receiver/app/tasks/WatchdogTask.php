<?php
namespace Pilight\Cli\Tasks;

use Phalcon\Cli\Task;
use Pilight\Host;
use Pilight\Watchdog;

/**
 * @property Host Host
 */
class WatchdogTask extends Task
{

    public function mainAction()
    {
        do {
            sleep(5);
        } while ((new Watchdog($this->Host))->ping());

        throw new \Exception(sprintf('Host %s:%d is gone.', $this->Host->getIp(), $this->Host->getPort()));
    }
}