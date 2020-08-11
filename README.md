# redis
Makise-Co Adapter of PHP Redis extenstion

## Usage
**WARNING**: This package can be used only in the Swoole Coroutine context

*INFO*: To get non-blocking Redis connection you should call \Swoole\Runtime::enableCoroutine();

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

## Additional methods
* RedisLazyConnection->transaction - giving an ability to execute sequence of commands on a single connection.
    Example:
    ```php
    /** @var \MakiseCo\Redis\RedisPool $pool */
    $conn = new \MakiseCo\Redis\RedisLazyConnection($pool);
    $value = $conn->transaction(function (\Redis $redis) {
        $redis->set('test', '123');
    
        return $redis->get('test');
    });
    // $value is '123'
    ```
