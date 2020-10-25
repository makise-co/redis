<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis\Tests;

use MakiseCo\Redis\ConnectionConfig;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testConfigCreated(): void
    {
        $config = ConnectionConfig::fromArray(
            [
                'host' => 'host.docker.internal',
            ]
        );

        self::assertSame('host.docker.internal', $config->getHost());
        self::assertNull($config->getUser());
        self::assertSame(6379, $config->getPort());
        self::assertNull($config->getPassword());
        self::assertSame(0.0, $config->getTimeout());
        self::assertSame(0.0, $config->getReadTimeout());
        self::assertNull($config->getReserved());
        self::assertSame(0, $config->getRetryInterval());
    }
}
