<?php

namespace PouchScanner\Domain;

/** Define the connection values */
class Connection
{
    /**
     * @param string $hostname The hostname to connect, some examples values are:localhost, 192.168.0.1, etc.
     * @param string $username The username to authenticate in the server
     * @param string $password The password to authenticate in the server
     * @param string $protocol The protocol to connect, default is 'https' possible values are: http and https
     */
    public function __construct(
        private readonly string $hostname,
        private readonly string $username,
        private readonly string $password,
        private readonly string $protocol = 'https',
        private readonly int $port = 443
    )
    {
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }
}
