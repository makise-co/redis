# redis
Makise-Co Adapter of PHP Redis extenstion

## Usage
**WARNING**: This package can be used only in the Swoole Coroutine context

*INFO*: To get non-blocking Redis connection you should call \Swoole\Runtime::enableCoroutine();

```php
<?php

declare(strict_types=1);

$pool = new \MakiseCo\Redis\RedisPool(
    // pass standard redis extension connect parameters
    \MakiseCo\Redis\ConnectionConfig::fromArray([
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
//        'password' => 'secret',
        'options' => [
            \Redis::OPT_SERIALIZER => \Redis::SERIALIZER_MSGPACK,
        ]
    ]),
);

// initialize connection pool
$pool->init();

$pool->set('key', 'value');
$pool->del('key');
$pool
    ->multi()
    ->set('key', 'value')
    ->exec();

// However pool cannot be used as \Redis instance for this purpose you should use RedisLazyConnection
// RedisLazyConnection is a pool wrapper that extends \Redis class

$lazyConnection = new \MakiseCo\Redis\RedisLazyConnection($pool);
$lazyConnection->set('key', 'value');
$lazyConnection->del('key');

$lazyConnection
    ->multi()
    ->set('key', 'value')
    ->exec();

```
