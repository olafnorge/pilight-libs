<?php
namespace Pilight;


final class Watchdog extends AbstractClient
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