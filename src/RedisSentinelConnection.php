<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use MakiseCo\Connection\ConnectionInterface;
use Predis\Client;

/**
 * @mixin \Predis\Client
 */
class RedisSentinelConnection implements ConnectionInterface
{
    private Client $redis;
    private int $lastUsedAt;

    public static function connect(SentinelConnectionConfig $config): self
    {
        $parameters = [
            'timeout' => $config->getTimeout(),
            'read_write_timeout' => $config->getReadTimeout(),
        ];

        if (null !== ($password = $config->getPassword())) {
            $parameters['password'] = $password;
        }

        if (null !== ($database = $config->getDatabase())) {
            $parameters['database'] = $database;
        }

        $options = [
            'replication' => 'sentinel',
            'service' => $config->getService(),
            'parameters' => $parameters,
        ];

        $client = new \Predis\Client($config->getHosts(), $options);
        $client->connect();

        return new self($client);
    }

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
        $this->lastUsedAt = \time();
    }

    public function close()
    {
        $this->redis->disconnect();
    }

    public function isAlive(): bool
    {
        return $this->redis->isConnected();
    }

    public function getLastUsedAt(): int
    {
        return $this->lastUsedAt;
    }

    /**
     * Delegate call to redis extension
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $this->lastUsedAt = \time();

        return $this->redis->{$name}(...$arguments);
    }
}
