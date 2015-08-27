<?php
namespace Pilight\Client;


final class Watchdog extends Client
{
    protected $options = ['core' => 1];

    public function ping()
    {
        if (false === fwrite($this->getSocket(), 'HEART', 1024)) {
            return false;
        }

        return trim(fgets($this->getSocket(), 1024)) === 'BEAT';
    }
}