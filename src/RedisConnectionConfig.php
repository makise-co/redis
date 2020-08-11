<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use MakiseCo\Pool\ConnectionConfigInterface;

class RedisConnectionConfig implements ConnectionConfigInterface
{
    private string $host;
    private int $port;
    private ?string $password;
    private int $database;
    private float $timeout;
    private $reserved;
    private int $retryInterval;
    private float $readTimeout;

    /**
     * RedisConnectionConfig constructor.
     * @param string $host
     * @param int $port
     * @param string|null $password
     * @param int $database
     * @param float $timeout
     * @param null $reserved
     * @param int $retryInterval
     * @param float $readTimeout
     */
    public function __construct(
        string $host,
        int $port,
        ?string $password,
        int $database,
        float $timeout = 0.0,
        $reserved = null,
        int $retryInterval = 0,
        float $readTimeout = 0.0
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->database = $database;
        $this->timeout = $timeout;
        $this->reserved = $reserved;
        $this->retryInterval = $retryInterval;
        $this->readTimeout = $readTimeout;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getUser(): ?string
    {
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getDatabase(): int
    {
        return $this->database;
    }

    public function getTimeout(): float
    {
        return $this->timeout;
    }

    public function getReserved()
    {
        return $this->reserved;
    }

    public function getRetryInterval(): int
    {
        return $this->retryInterval;
    }

    public function getReadTimeout(): float
    {
        return $this->readTimeout;
    }

    public function toArray(): array
    {
        return [
            'host' => $this->host,
            'port' => $this->port,
            'password' => $this->password,
            'database' => $this->database,
            'timeout' => $this->timeout,
            'reserved' => $this->reserved,
            'retryInterval' => $this->retryInterval,
            'readTimeout' => $this->readTimeout,
        ];
    }

    public static function fromArray(array $config): self
    {
        return new self(
            $config['host'] ?? '127.0.0.1',
            $config['port'] ?? 6379,
            $config['password'] ?? null,
            $config['database'] ?? 0,
            $config['timeout'] ?? 0.0,
            $config['reserved'] ?? null,
            $config['retryInterval'] ?? $config['retry_interval'] ?? 0,
            $config['readTimeout'] ?? $config['read_timeout'] ?? 0.0,
        );
    }

    public function __toString(): string
    {
        throw new \LogicException('__toString() is not implemented');
    }
}
