<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis\Tests;

use MakiseCo\Redis\RedisPool;
use PHPUnit\Framework\TestCase;

class RedisPoolTest extends TestCase
{
    use CoroutineTestTrait;

    public function testCreate(): void
    {
        $this->runCoroWithPool(function (RedisPool $pool) {
            $redis = $pool->borrow();

            self::assertInstanceOf(\Redis::class, $redis);
            self::assertSame(0, $pool->getIdleCount());

            self::assertTrue($redis->isConnected());
            self::assertSame(3, $redis->getDbNum());

            $pool->return($redis);

            self::assertSame(1, $pool->getIdleCount());

            $pool->close();
        });
    }
}
