<?php


require 'src/PiligthListener.php';

(new PiligthListener())->receive([new Callback(), 'call']);

(new PiligthListener())->receive(['print_r', function ($message) {
    sleep(30);
    echo PHP_EOL . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $message;
}, [new Callback(), 'call']]);

class Callback
{

    public function call($message)
    {
        echo PHP_EOL . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $message;
    }
}


