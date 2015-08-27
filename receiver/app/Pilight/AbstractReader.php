<?php
namespace Pilight;


abstract class AbstractReader extends AbstractClient
{
    protected $action = '';
    protected $command = [];

    protected function callback($callback, $message)
    {
        return call_user_func($callback ? $callback : [$this, 'evaluate'], $message);
    }

    protected function evaluate(array $message)
    {
        return $message;
    }

    public function read($callback = null)
    {
        $query = json_encode(array_merge(['action' => $this->action], $this->command, ['media' => 'all']));

        if (false === fwrite($this->getSocket(), $query, 1024)) {
            return false;
        }

        $buffer = '';
        $response = ['status' => 'failed'];
        $callCount = 0;

        do {
            $buffer .= fgets($this->getSocket(), 1024);
            $length = strlen($buffer);

            if ($length > 2 && 10 === ord($buffer[$length - 1]) && 10 === ord($buffer[$length - 2])) {
                $response = json_decode(trim(substr($buffer, 0, -2)), true);
                break;
            }
        } while (!feof($this->getSocket()) || $callCount++ < 100);

        if ($response === ['status' => 'failed']) {
            return false;
        }

        return $this->callback($callback, $response);
    }
}