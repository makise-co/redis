<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use Redis;
use Smf\ConnectionPool\Connectors\ConnectorInterface;

use function array_key_exists;

class RedisConnector implements ConnectorInterface
{
    public function connect(array $config): Redis
    {
        $config = $this->getConfig($config);

        $connection = new Redis();
        $connection->connect(
            $config['host'],
            $config['port'] ?? 6379,
            $config['timeout'] ?? 0.0,
            $config['reserved'] ?? null,
            $config['retryInterval'] ?? 0,
            $config['readTimeout'] ?? 0.0
        );

        if (array_key_exists('password', $config) && null !== $config['password']) {
            $connection->auth($config['password']);
        }

        if (array_key_exists('database', $config) && null !== $config['database']) {
            $connection->select($config['database']);
        }

        return $connection;
    }

    public function disconnect($connection): void
    {
        /** @var Redis $connection */
        $connection->close();
    }

    public function isConnected($connection): bool
    {
        /** @var Redis $connection */
        return $connection->isConnected();
    }

    public function reset($connection, array $config): void
    {
    }

    public function validate($connection): bool
    {
        return $connection instanceof Redis;
    }

    private function getConfig(array $config): array
    {
        if (!array_key_exists('connection_config', $config)) {
            return $config;
        }

        $connectionConfig = $config['connection_config'];

        if (!$connectionConfig instanceof RedisConnectionConfig) {
            return $config;
        }

        return $connectionConfig->toArray();
    }
}
