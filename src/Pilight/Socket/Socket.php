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

namespace Pilight\Socket;

use Pilight\Socket\Exception\MessageNotSentException;
use Pilight\Socket\Exception\OptionNotSetException;
use Pilight\Socket\Exception\ReceiveException;
use Pilight\Socket\Exception\SocketNotCreatedException;

class Socket
{
    /** @var resource */
    private $handle;

    /**
     * @param resource $handle the socket handle
     */
    public function __construct($handle)
    {
        if (!is_resource($handle)) {
            throw new \InvalidArgumentException('Given socket handle is not a valid resource.');
        }

        $this->handle = $handle;
    }

    /**
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    public function close()
    {
        socket_close($this->handle);
    }

    /**
     * @param Message  $message
     * @param Endpoint $endpoint
     * @param int      $flags
     *
     * @see socket_sendto()
     *
     * @return int
     *
     * @throws MessageNotSentException on error
     */
    public function sendTo(Message $message, Endpoint $endpoint, $flags = 0)
    {
        $bytesSent = socket_sendto(
            $this->handle,
            $message->getPayload(),
            $message->getLength(),
            $flags,
            $endpoint->getAddress(),
            $endpoint->getPort()
        );

        if (false === $bytesSent) {
            throw new MessageNotSentException($this->getLastErrorMessage(), $this->getLastError());
        }

        return $bytesSent;
    }

    /**
     * @param string $buffer
     * @param int    $flags
     *
     * @see socket_recvfrom()
     *
     * @return int bytes received
     */
    public function receive(&$buffer, $flags = MSG_WAITALL)
    {
        $bytes = socket_recvfrom($this->handle, $buffer, Message::DEFAULT_LENGTH, $flags, $socketName, $socketPort);

        if (false === $bytes) {
            throw new ReceiveException($this->getLastErrorMessage(), $this->getLastError());
        }

        return $bytes;
    }

    /**
     * @param int $domain
     * @param int $type
     * @param int $protocol
     *
     * @see socket_create()
     *
     * @return Socket
     *
     * @throws SocketNotCreatedException
     */
    public static function create($domain, $type, $protocol)
    {
        $resource = socket_create($domain, $type, $protocol);

        if (!$resource) {
            throw new SocketNotCreatedException(socket_strerror(socket_last_error()), socket_last_error());
        }

        return new static($resource);
    }

    /**
     * @param int $microseconds
     * @throws OptionNotSetException
     *
     * @return true
     */
    public function setTimeout($microseconds)
    {
        $value = array('sec' => 0, 'usec' => $microseconds);

        return $this->setOption(SOL_SOCKET, SO_RCVTIMEO, $value);
    }

    /**
     * @param int   $level
     * @param int   $optionName
     * @param mixed $optionValue
     * @throws OptionNotSetException
     *
     * @return true - throws exception on error
     */
    public function setOption($level, $optionName, $optionValue)
    {
        if (false === socket_set_option($this->handle, $level, $optionName, $optionValue)) {
            throw new OptionNotSetException($this->getLastErrorMessage(), $this->getLastError());
        }

        return true;
    }

    /**
     * @return int the error code
     */
    public function getLastError()
    {
        return socket_last_error($this->handle);
    }

    /**
     * @return string the error message
     */
    public function getLastErrorMessage()
    {
        return socket_strerror($this->getLastError());
    }
}