<?php
namespace Pilight\Cli\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{

    public function mainAction()
    {
        echo PHP_EOL;
        echo 'Subscribers:' . PHP_EOL;
        echo '  php app/cli.php config' . PHP_EOL;
        echo '  php app/cli.php core' . PHP_EOL;
        echo '  php app/cli.php forward' . PHP_EOL;
        echo '  php app/cli.php message' . PHP_EOL;
        echo '  php app/cli.php stats' . PHP_EOL;
        echo '  php app/cli.php watchdog' . PHP_EOL;
        echo PHP_EOL;
    }
}