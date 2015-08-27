<?php
namespace Pilight\Client;


final class Heartbeat extends Client
{

    public function ping()
    {
        if (false === fwrite($this->getSocket(), 'HEART', 1024)) {
            return false;
        }

        return trim(fgets($this->getSocket(), 1024)) === 'BEAT';
    }
}