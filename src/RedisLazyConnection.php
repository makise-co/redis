<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use Redis;

/**
 * Redis connection pool wrapper, connection pool can be used as usual redis connection
 */
class RedisLazyConnection extends Redis
{
    use RedisTrait;

    private RedisPool $pool;

    public function __construct(RedisPool $pool)
    {
        $this->pool = $pool;

        parent::__construct();
    }

    protected function call($name, $arguments)
    {
        return $this->pool->{$name}(...$arguments);
    }
}
