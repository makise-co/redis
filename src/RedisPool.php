<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use MakiseCo\Pool\ConnectionConfigInterface;
use MakiseCo\Pool\ConnectionPool;
use MakiseCo\Pool\PoolConfigInterface;
use Redis;
use Smf\ConnectionPool\Connectors\ConnectorInterface;

class RedisPool extends ConnectionPool
{
    public function __construct(
        PoolConfigInterface $poolConfig,
        ?ConnectorInterface $connector,
        ConnectionConfigInterface $connectionConfig
    ) {
        if (null === $connector) {
            $connector = new RedisConnector();
        }

        parent::__construct($poolConfig, $connector, $connectionConfig);
    }

    public function borrow(): Redis
    {
        return parent::borrow();
    }
}
