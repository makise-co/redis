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
use Redis;

/**
 * @mixin \Redis
 */
class RedisConnection implements ConnectionInterface
{
    private Redis $redis;
    private int $lastUsedAt;

    public static function connect(ConnectionConfig $config): self
    {
        $connection = new Redis();

        foreach ($config->getOptions() as $optionKey => $optionValue) {
            $connection->setOption($optionKey, $optionValue);
        }

        $connection->connect(
            $config->getHost(),
            $config->getPort(),
            $config->getTimeout(),
            $config->getReserved(),
            $config->getRetryInterval(),
            $config->getReadTimeout()
        );

        if (null !== ($password = $config->getPassword())) {
            $connection->auth($password);
        }

        if (null !== ($database = $config->getDatabase())) {
            $connection->select($database);
        }

        return new self($connection);
    }

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
        $this->lastUsedAt = \time();
    }

    public function close()
    {
        $this->redis->close();
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
