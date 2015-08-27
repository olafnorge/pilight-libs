<?php
namespace Pilight;


abstract class AbstractClient
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

        print_r([$this->uuid()]);

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
        $bytes = openssl_random_pseudo_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40); // set version to 0100
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 2));
    }
}