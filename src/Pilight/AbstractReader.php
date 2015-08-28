<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Volker Machon
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Pilight;

/**
 * Class AbstractReader
 * @package Pilight
 */
abstract class AbstractReader extends AbstractClient
{
    protected $action = '';
    protected $command = [];

    /**
     * @param $callback
     * @param $message
     * @return mixed
     */
    protected function callback($callback, $message)
    {
        return call_user_func($callback ? $callback : [$this, 'evaluate'], $message);
    }

    /**
     * @param array $message
     * @return array
     */
    protected function evaluate(array $message)
    {
        return $message;
    }

    /**
     * @param null $callback
     * @return bool|mixed
     */
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