# redis
Makise-Co Adapter of PHP Redis extenstion

## Usage
```php
<?php

declare(strict_types=1);

$pool = new \MakiseCo\Redis\RedisPool(
    // look at pool config class reference
    new \MakiseCo\Pool\PoolConfig(...),
    null,
    // pass standard redis extension connect parameters
    \MakiseCo\Redis\RedisConnectionConfig::fromArray([]),
);

// initialize connection pool
$pool->init();

$redisConnection = $pool->borrow();

// do something with connection

$pool->return($redisConnection);

// or you can use LazyConnection that will automatically take and return connection from the pool
$lazyConnection = new \MakiseCo\Redis\RedisLazyConnection($pool);
// connection is automatically borrowed and returned to the pool
// WARNING: Transactions and pipelining is not supported yet
$lazyConnection->set('key', 'value');
```
