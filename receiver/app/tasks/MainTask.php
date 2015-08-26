<?php
namespace Url2png\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{

    public function mainAction()
    {
        echo PHP_EOL . '# Usage:' . PHP_EOL;
        echo 'Capturw related actions:' . PHP_EOL;
        echo '  php app/cli.php capture process' . PHP_EOL;
        echo '  php app/cli.php capture reload' . PHP_EOL;
        echo 'User related actions:' . PHP_EOL;
        echo '  php app/cli.php user create <username>' . PHP_EOL;
        echo '  php app/cli.php user delete <username>' . PHP_EOL;
        echo '  php app/cli.php user reset <username>' . PHP_EOL;
        echo PHP_EOL;
    }
}