<?php
namespace Pilight;

/**
 * Class Watchdog
 * @package Pilight
 */
final class Watchdog
{
    private $socket = null;

    /**
     * @param Host $Host
     * @throws \Exception
     */
    public function __construct(Host $Host)
    {
        $this->socket = fsockopen($Host->getIp(), $Host->getPort(), $errorNumber, $errorDescription, 0.5);

        if (false === $this->socket) {
            throw new \Exception($errorDescription, $errorNumber);
        }
    }

    public function __destruct()
    {
        if ($this->socket) {
            fclose($this->socket);
        }
    }


    /**
     * @return bool
     */
    public function ping()
    {
        if (false === fwrite($this->socket, 'HEART', 1024)) {
            return false;
        }

        return trim(fgets($this->socket, 1024)) === 'BEAT';
    }
}