<?php
namespace Pilight\Client;


abstract class Publisher extends Client
{
    protected $action = '';

    protected function callback($callback, $message)
    {
        return call_user_func($callback, $message);
    }

    protected function evaluate(array $message)
    {
        return $message;
    }

    public function publish(array $command, $callback = null)
    {
        $query = json_encode(array_merge(['action' => $this->action], $command, ['media' => 'all']));

        print_r($query);

        if (false === fwrite($this->getSocket(), $query, 1024)) {
            return false;
        }

        $buffer = '';
        $response = ['status' => 'failed'];

        do {
            $buffer .= fgets($this->getSocket(), 1024);
            $length = strlen($buffer);

            if ($length > 2 && 10 === ord($buffer[$length - 1]) && 10 === ord($buffer[$length - 2])) {
                $response = json_decode(trim(substr($buffer, 0, -2)), true);
                break;
            }
        } while (true);

        if ($response === ['status' => 'failed']) {
            return false;
        }

        return $this->callback($callback, $response);
    }
}