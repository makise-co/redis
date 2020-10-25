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

class RedisConnector implements ConnectorInterface
{
    /**
     * @param ConnectionConfigInterface|ConnectionConfig $config
     * @return RedisConnection
     */
    public function connect(ConnectionConfigInterface $config): RedisConnection
    {
        return RedisConnection::connect($config);
    }
}
