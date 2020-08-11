<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis\Tests;

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

    public function testFakeTransaction(): void
    {
        $this->runCoroWithPool(static function (RedisPool $pool) {
            $conn = new RedisLazyConnection($pool);
            $res = $conn->transaction(static function (\Redis $redis) use ($pool) {
                self::assertTrue($redis->isConnected());
                self::assertSame(0, $pool->getIdleCount());

                $redis->set('test', '456');
                self::assertSame('456', $redis->get('test'));

                return true;
            });

            self::assertTrue($res);

            self::assertSame(1, $pool->getIdleCount());
        });
    }
}
