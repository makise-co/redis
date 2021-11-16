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
use MakiseCo\Redis\RedisSentinelConnector;
use MakiseCo\Redis\SentinelConnectionConfig;
use PHPUnit\Framework\TestCase;

class RedisSentinelConnectorTest extends TestCase
{
    public function testConnect(): void
    {
        $config = SentinelConnectionConfig::fromArray(
            [
                'hosts' => ['127.0.0.1:26379'],
                'timeout' => 1.0,
                'database' => 3,
//                'password' => 'secret',
                'service' => 'mymaster',
            ]
        );

        $connector = new RedisSentinelConnector();
        $redis = $connector->connect($config);

        self::assertTrue($redis->isConnected());

        $redis->set('kv', 1);
        self::assertSame(1, (int)$redis->get('kv'));

        $redis->close();

        $pool = new RedisPool(
            $config,
            new RedisSentinelConnector(),
        );

        $pool->setMaxActive(2);
        $poolVal = null;

        \Swoole\Coroutine\run(static function () use ($pool, &$poolVal) {
            $pool->init();

            try {
                $pool->set('kv', 2);
                $poolVal = (int)$pool->get('kv');
            } finally {
                $pool->close();
            }
        });

        self::assertSame(2, $poolVal);
    }
}
