<?php
namespace Pilight;

/**
 * Class Watchdog
 * @package Pilight
 */
final class Watchdog extends AbstractClient
{
    protected $options = ['core' => 1];

    /**
     * @return bool
     */
    public function ping()
    {
        if (false === fwrite($this->getSocket(), 'HEART', 1024)) {
            return false;
        }

        return trim(fgets($this->getSocket(), 1024)) === 'BEAT';
    }
}