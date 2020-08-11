<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis\Tests;

use MakiseCo\Redis\RedisConnectionConfig;
use MakiseCo\Redis\RedisConnector;
use PHPUnit\Framework\TestCase;

class RedisConnectorTest extends TestCase
{
    public function testConnect(): void
    {
        $config = RedisConnectionConfig::fromArray(
            [
                'host' => '127.0.0.1',
                'port' => 6379,
                'timeout' => 1.0,
                'database' => 3,
            ]
        );

        $connector = new RedisConnector();
        $redis = $connector->connect(['connection_config' => $config]);

        self::assertTrue($redis->isConnected());
        self::assertSame(1.0, $redis->getTimeout());
        self::assertSame(3, $redis->getDbNum());

        $redis->close();
    }
}
