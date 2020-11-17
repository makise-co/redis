<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use Closure;
use Redis;

/**
 * Represents Redis transaction object
 */
class PooledRedisConnection extends Redis
{
    use RedisTrait;

    private Redis $connection;
    private ?Closure $release;

    /**
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     * @param Redis $connection
     * @param Closure $release
     */
    public function __construct(Redis $connection, Closure $release)
    {
        $this->connection = $connection;
        $this->release = $release;
    }

    public function __destruct()
    {
        try {
            $this->discard();
        } catch (\Throwable $e) {
            // ignore errors
        }
    }

    private function releaseConnection(): void
    {
        if ($this->release) {
            $release = $this->release;
            $this->release = null;

            $release();
        }
    }

    public function exec()
    {
        try {
            return $this->connection->exec();
        } finally {
            $this->releaseConnection();
        }
    }

    public function discard(): void
    {
        try {
            $this->connection->discard();
        } finally {
            $this->releaseConnection();
        }
    }

    protected function call($name, $arguments)
    {
        return $this->connection->{$name}(...$arguments);
    }
}
