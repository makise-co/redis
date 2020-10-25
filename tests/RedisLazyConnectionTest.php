<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis\Tests;

use MakiseCo\Redis\PooledRedisConnection;
use MakiseCo\Redis\RedisConnection;
use MakiseCo\Redis\RedisLazyConnection;
use MakiseCo\Redis\RedisPool;
use PHPUnit\Framework\TestCase;

class RedisLazyConnectionTest extends TestCase
{
    use CoroutineTestTrait;

    public function testSet(): void
    {
        $this->runCoroWithPool(static function (RedisPool $pool) {
            $conn = new RedisLazyConnection($pool);
            $conn->set('test', '123');

            self::assertSame('123', $conn->get('test'));
        });
    }

    public function testOpenIsNotSupported(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('open is not supported');

        $this->runCoroWithPool(static function (RedisPool $pool) {
            $conn = new RedisLazyConnection($pool);
            $conn->open('test');
        });
    }

    public function testTransaction(): void
    {
        $this->runCoroWithPool(static function (RedisPool $pool) {
            $pool->setMaxActive(2);

            $pool->del('key');

            $conn = new RedisLazyConnection($pool);

            // starting transaction
            $redis = $conn->multi();
            self::assertInstanceOf(PooledRedisConnection::class, $redis);

            // setting key in transaction
            $redis->set('key', '123');

            // checking the key is not seen by another connection
            self::assertNotSame('123', $conn->get('key'));

            // committing transaction
            $redis->exec();

            // checking the key is now seen by another connection
            self::assertSame('123', $conn->get('key'));

            // connections should be returned to the pool
            self::assertSame(2, $pool->getIdleCount());

            // ------ TESTING ROLLBACK

            $pool->del('key');

            // starting transaction
            $redis = $conn->multi();
            self::assertInstanceOf(PooledRedisConnection::class, $redis);

            // One free connection should remain
            self::assertSame(1, $pool->getIdleCount());

            // setting key in transaction
            $redis->set('key', '123');

            // checking the key is not seen by another connection
            self::assertNotSame('123', $conn->get('key'));

            // transaction rollback
            $redis->discard();

            // checking key changes does not happen
            self::assertNotSame('123', $conn->get('key'));

            // connections should be returned to the pool
            self::assertSame(2, $pool->getIdleCount());
        });
    }
}
