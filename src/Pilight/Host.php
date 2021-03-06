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

use Pilight\Socket\Endpoint;
use Pilight\Socket\Exception\SocketException;
use Pilight\Socket\Message;
use Pilight\Socket\Socket;

/**
 * Class Host
 * @package Pilight
 */
final class Host
{
    private $ip = '';
    private $port = 0;

    /**
     * @param string $ip
     * @param int $port
     * @throws \Exception
     */
    public function __construct($ip = '', $port = 0)
    {
        if ($ip && $port) {
            $this->ip = $ip;
            $this->port = $port;
        } elseif (!$this->discover()) {
            throw new \Exception('No SSDP host discovered.');
        }
    }

    /**
     * Discovers SSDP host
     *
     * @param string $discoveryHost
     * @param int    $discoveryPort
     *
     * @return Host with discoverd SSDP host settings
     *
     * @throws HostDiscoveryException if discovery didn't work properly
     * @throws SocketException if any socket interaction fails
     *
     * @todo Remove default value for $discoveryHost argument - make sure to call it properly from the outside
     * @todo Remove default value for $discoveryPort argument - make sure to call it properly from the outside
     */
    public static function discover($discoveryHost = '239.255.255.25', $discoveryPort = 1900)
    {
        $endpoint = new Endpoint($discoveryHost, $discoveryPort);

        $headers = implode("\r\n", [
            'M-SEARCH * HTTP/1.1',
            'Host: ' . $endpoint,
            'ST: urn:schemas-upnp-org:service:pilight:1',
            'Man: ssdp:discover',
            'MX: 3',
        ]) . "\r\n\r\n";

        $socket = Socket::create(AF_INET, SOCK_DGRAM, SOL_UDP);
        $socket->setTimeout(10000);
        $socket->sendTo(new Message($headers), $endpoint);

        $buffer = '';
        $ip = '';
        $port = '';

        while ($socket->receive($buffer)) {
            if (false !== strpos($buffer, 'pilight')) {
                $hostOctet1 = 0;
                $hostOctet2 = 0;
                $hostOctet3 = 0;
                $hostOctet4 = 0;
                $hostPort = 0;

                foreach (explode("\r\n", $buffer) as $bufferLine) {
                    if (5 === sscanf($bufferLine, "Location:%d.%d.%d.%d:%d\r\n", $hostOctet1, $hostOctet2, $hostOctet3, $hostOctet4, $hostPort)) {
                        $ip = $hostOctet1 . '.' . $hostOctet2 . '.' . $hostOctet3 . '.' . $hostOctet4;
                        $port = $hostPort;
                        break 2;
                    }
                }
            }
        }

        $socket->close();

        if ($ip && $port) {
            return new static($ip, $port);
        }

        throw new HostDiscoveryException('Host could not be discovered.');
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }
}
