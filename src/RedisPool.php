<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use MakiseCo\Connection\ConnectorInterface;
use MakiseCo\Pool\Pool;

/**
 * @mixin \Redis
 */
class RedisPool extends Pool
{
    protected function createDefaultConnector(): ConnectorInterface
    {
        return new RedisConnector();
    }

    public function multi(int $mode = \Redis::MULTI)
    {
        /** @var RedisConnection $connection */
        $connection = $this->pop();

        $newRedis = $connection->multi($mode);

        return new PooledRedisConnection($newRedis, function () use ($connection) {
            $this->push($connection);
        });
    }

    public function pipeline()
    {
        return $this->multi(\Redis::PIPELINE);
    }

    /**
     * Call method on redis connection
     *
     * @param string $method
     * @param mixed $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $connection = $this->pop();

        try {
            return $connection->{$method}(...$args);
        } finally {
            $this->push($connection);
        }
    }
}
