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