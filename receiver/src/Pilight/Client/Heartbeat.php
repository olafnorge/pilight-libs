<?php
namespace Pilight\Client;


use Pilight\Host\Host;

final class Heartbeat implements ClientInterface
{
    private $Host = null;
    private $socket = null;

    /**
     * Registers as listener to $Host
     *
     * @param Host $Host
     * @throws \Exception if SSDP host can't be discovered or listener can't be registered
     */
    public function __construct(Host $Host)
    {
        $this->Host = $Host;

        if (!$this->register()) {
            throw new \Exception('Unable to register at host.');
        }
    }

    public function __destruct()
    {
        if ($this->socket) {
            fclose($this->socket);
        }
    }

    protected function getSocket()
    {
        return $this->socket;
    }

    /**
     * Registers at SSDP host
     * @return bool true if registration at SSDP host was successful otherwise false
     * @throws \Exception if any socket interaction fails
     */
    private function register()
    {
        $this->socket = fsockopen($this->Host->getIp(), $this->Host->getPort(), $errorNumber, $errorDescription, 0.5);

        if (false === $this->socket) {
            throw new \Exception($errorDescription, $errorNumber);
        }

        return true;
    }


    public function execute()
    {
        if (false === fwrite($this->socket, 'HEART', 1024)) {
            return false;
        }

        return trim(fgets($this->getSocket(), 1024)) === 'BEAT';
    }
}