<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

class SentinelConnectionConfig extends ConnectionConfig
{
    /**
     * List of sentinel hosts
     *
     * @var string[]
     */
    private array $hosts;

    /**
     * Master name
     */
    private string $service;

    /**
     * @param string[] $hosts list of sentinel hosts
     * @param string|null $password
     * @param int $database
     * @param float $timeout
     * @param int $retryInterval
     * @param float $readTimeout
     * @param array $options
     * @param string $service master name
     */
    public function __construct(
        array $hosts,
        ?string $password,
        int $database,
        float $timeout = 0.0,
        int $retryInterval = 0,
        float $readTimeout = 0.0,
        array $options = [],
        string $service = 'mymaster'
    ) {
        parent::__construct(
            '',
            0,
            $password,
            $database,
            $timeout,
            null,
            $retryInterval,
            $readTimeout,
            $options
        );

        $this->hosts = $hosts;
        $this->service = $service;
    }

    /**
     * @return string[]
     */
    public function getHosts(): array
    {
        return $this->hosts;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function toArray(): array
    {
        $parent = parent::toArray();
        $parent['hosts'] = $this->hosts;
        $parent['service'] = $this->service;

        return $parent;
    }

    public static function fromArray(array $config): self
    {
        return new self(
            $config['hosts'] ?? ['127.0.0.1'],
            $config['password'] ?? null,
            $config['database'] ?? 0,
            $config['timeout'] ?? 0.0,
            $config['retryInterval'] ?? $config['retry_interval'] ?? 0,
            $config['readTimeout'] ?? $config['read_timeout'] ?? 0.0,
            $config['options'] ?? [],
            $config['service'] ?? 'mymaster',
        );
    }
}
