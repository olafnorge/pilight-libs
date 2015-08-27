<?php
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

} catch (\Exception $Exception) {

}
