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
 * Class AbstractSubscriber
 * @package Pilight
 */
abstract class AbstractSubscriber extends AbstractClient
{
    protected $filters = [];

    /**
     * Attaches to socket and reads messages from it
     * @param $callbacks string|array any valid callback that can be passed to 'call_user_func'
     * @throws \Exception
     */
    final public function listen($callbacks)
    {
        $buffer = '';

        do {
            $buffer .= fgets($this->getSocket(), 1024);
            $length = strlen($buffer);

            if ($length > 2 && 10 === ord($buffer[$length - 1]) && 10 === ord($buffer[$length - 2])) {
                $message = json_decode(trim(substr($buffer, 0, -2)), true);

                if (isset($message['origin']) && (empty($this->filters) || in_array($message['origin'], $this->filters))) {
                    $this->callback($callbacks, $message);
                }

                $buffer = '';
            }
        } while ($this->isAlive());

        throw new \Exception('Connection to host lost.');
    }
}