<?php
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', realpath(__DIR__ . DS . '..' . DS));

try {

} catch (\Exception $Exception) {
    header('HTTP/1.1 500 Internal Server Error');
}

