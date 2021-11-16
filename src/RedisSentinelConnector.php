<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use MakiseCo\Connection\ConnectionConfigInterface;
use MakiseCo\Connection\ConnectorInterface;

class RedisSentinelConnector implements ConnectorInterface
{
    /**
     * @param ConnectionConfigInterface|ConnectionConfig $config
     * @return RedisSentinelConnection
     */
    public function connect(ConnectionConfigInterface $config): RedisSentinelConnection
    {
        if (!$config instanceof SentinelConnectionConfig) {
            throw new \InvalidArgumentException("SentinelConnectionConfig should be passed");
        }

        return RedisSentinelConnection::connect($config);
    }
}
