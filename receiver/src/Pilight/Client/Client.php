<?php
namespace Pilight\Client;


use Pilight\Host\Host;

abstract class Client
{
    private $Host = null;
    private $socket = null;
    protected $options = ['core' => 1, 'config' => 1, 'forward' => 1, 'receiver' => 1, 'stats' => 1];

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

    protected function callback($callbacks, $message)
    {
        if (is_array($callbacks) && count($callbacks) > 2) {
            foreach ($callbacks as $callback) {
                call_user_func($callback, $message);
            }
        } else {
            call_user_func($callbacks, $message);
        }
    }

    /**
     * Registers at SSDP host
     * @return bool true if registration at SSDP host was successful otherwise false
     * @throws \Exception if any socket interaction fails
     */
    private function register()
    {
        $this->socket = fsockopen($this->Host->getIp(), $this->Host->getPort(), $errorNumber, $errorDescription, 0.5);
        $query = json_encode([
            'action' => 'identify',
            'options' => $this->options,
            'media' => 'all',
            'uuid' => $this->uuid(),
        ]);

        if (false === $this->socket) {
            throw new \Exception($errorDescription, $errorNumber);
        }

        if (false === fwrite($this->socket, $query, 1024)) {
            return false;
        }

        if (json_decode(fgets($this->socket, 1024), true) !== ['status' => 'success']) {
            return false;
        }

        return true;
    }


    private function uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}