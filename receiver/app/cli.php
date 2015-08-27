<?php
use Phalcon\Cli\Console;
use Phalcon\Di\FactoryDefault\Cli;
use Phalcon\Loader;
use Pilight\Host;

define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', realpath(__DIR__ . DS . '..' . DS));

require APP_PATH . DS . 'vendor' . DS . 'autoload.php';

try {
    if (isset($_SERVER['SERVER_SOFTWARE'])) {
        throw new \RuntimeException('Must be run on console only.');
    }

    $arguments = [
        'task' => 'main',
        'action' => 'main',
        'params' => [],
    ];

    foreach ($argv as $k => $arg) {
        if ($k == 1) {
            $arguments['task'] = $arg;
        } elseif ($k == 2) {
            $arguments['action'] = $arg;
        } elseif ($k >= 3) {
            $arguments['params'][] = $arg;
        }
    }

    // bootstrap cli
    (new Loader())->registerNamespaces([
        'Pilight\Cli\Tasks' => APP_PATH . DS . 'app' . DS . 'tasks',
    ])->register();
    $Cli = new Cli();
    $Cli->get('dispatcher')->setDefaultNamespace('Pilight\Cli\Tasks');
    $Cli->get('dispatcher')->setNamespaceName('Pilight\Cli\Tasks');

    $Host = new Host(getenv('PILIGHT_IP'), getenv('PILIGHT_PORT'));
    $Cli->set('Host', function () use ($Host) {
        return $Host;
    }, true);

    $Console = new Console($Cli);
    $Console->handle($arguments);
} catch (\Exception $Exception) {
    trigger_error($Exception->getMessage(), E_USER_ERROR);
    exit(1);
}
