<?php
namespace Pilight\Host;


final class Host
{
    private $ip = '';
    private $port = 0;

    public function __construct()
    {
        if (!$this->discover()) {
            throw new \Exception('No SSDP host discovered.');
        }
    }


    /**
     * Discovers SSDP host
     * @return bool true if SSDP host discovery was successful otherwise false
     * @throws \Exception if any socket interaction fails
     */
    private function discover()
    {
        $headers = implode("\r\n", [
                'M-SEARCH * HTTP/1.1',
                'Host: 239.255.255.250:1900',
                'ST: urn:schemas-upnp-org:service:pilight:1',
                'Man: ssdp:discover',
                'MX: 3',
            ]) . "\r\n\r\n";

        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

        if (false === $socket) {
            throw new \Exception(socket_strerror(socket_last_error()), socket_last_error());
        }

        if (false === socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 0, 'usec' => 10000))) {
            throw new \Exception(socket_strerror(socket_last_error($socket)), socket_last_error());
        }

        if (false === socket_sendto($socket, $headers, 1024, 0, '239.255.255.250', 1900)) {
            throw new \Exception(socket_strerror(socket_last_error($socket)), socket_last_error());
        }

        $buffer = '';
        $socketName = '';
        $socketPort = '';

        while (socket_recvfrom($socket, $buffer, 1024, MSG_WAITALL, $socketName, $socketPort)) {
            if (false !== strpos($buffer, 'pilight')) {
                $hostOctect1 = 0;
                $hostOctect2 = 0;
                $hostOctect3 = 0;
                $hostOctect4 = 0;
                $hostPort = 0;

                foreach (explode("\r\n", $buffer) as $bufferLine) {
                    if (5 === sscanf($bufferLine, "Location:%d.%d.%d.%d:%d\r\n", $hostOctect1, $hostOctect2, $hostOctect3, $hostOctect4, $hostPort)) {
                        $this->ip = $hostOctect1 . '.' . $hostOctect2 . '.' . $hostOctect3 . '.' . $hostOctect4;
                        $this->port = $hostPort;
                        break 2;
                    }
                }
            }
        }

        socket_close($socket);

        return !empty($this->ip) && !empty($this->port);
    }


    public function getIp()
    {
        return $this->ip;
    }


    public function getPort()
    {
        return $this->port;
    }
}
