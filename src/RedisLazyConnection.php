<?php
/*
 * This file is part of the Makise-Co Framework
 *
 * World line: 0.571024a
 * (c) Dmitry K. <coder1994@gmail.com>
 */

declare(strict_types=1);

namespace MakiseCo\Redis;

use Smf\ConnectionPool\ConnectionPool;
use Redis;

use function call_user_func_array;

class RedisLazyConnection extends Redis
{
    /**
     * @var ConnectionPool
     */
    private ConnectionPool $pool;

    public function __construct(ConnectionPool $pool)
    {
        $this->pool = $pool;

        parent::__construct();
    }

    public function call(string $name, ...$arguments)
    {
        $connection = $this->pool->borrow();

        try {
            return call_user_func_array([$connection, $name], ...$arguments);
        } finally {
            $this->pool->return($connection);
        }
    }

    /**
     * Execute operations over a single connection
     *
     * @param \Closure $closure
     * @return mixed
     * @throws \Smf\ConnectionPool\BorrowConnectionTimeoutException
     */
    public function transaction(\Closure $closure)
    {
        $connection = $this->pool->borrow();

        try {
            return $closure($connection);
        } finally {
            $this->pool->return($connection);
        }
    }

    public function connect(
        $host,
        $port = 6379,
        $timeout = 0.0,
        $reserved = null,
        $retryInterval = 0,
        $readTimeout = 0.0
    ) {
        throw new \LogicException('connect is not supported');
    }

    /**
     * {@inheritDoc}
     */
    public function open(
        $host,
        $port = 6379,
        $timeout = 0.0,
        $reserved = null,
        $retryInterval = 0,
        $readTimeout = 0.0
    ) {
        throw new \LogicException('open is not supported');
    }

    /**
     * {@inheritDoc}
     */
    public function isConnected()
    {
        throw new \LogicException('isConnected is not supported');
    }

    /**
     * {@inheritDoc}
     */
    public function getHost()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getPort()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getDbNum()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeout()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getReadTimeout()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getPersistentID()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAuth()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pconnect(
        $host,
        $port = 6379,
        $timeout = 0.0,
        $persistentId = null,
        $retryInterval = 0,
        $readTimeout = 0.0
    ) {
        throw new \LogicException('pconnect is not supported');
    }

    /**
     * {@inheritDoc}
     */
    public function popen(
        $host,
        $port = 6379,
        $timeout = 0.0,
        $persistentId = '',
        $retryInterval = 0,
        $readTimeout = 0.0
    ) {
        throw new \LogicException('popen is not supported');
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        throw new \LogicException('close is not supported');
    }

    /**
     * {@inheritDoc}
     */
    public function swapdb($srcdb, $dstdb)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($option, $value)
    {
        throw new \LogicException('setOption is not supported');
    }

    /**
     * {@inheritDoc}
     */
    public function getOption($option)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function ping()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function echo($message)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function get($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $timeout = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function setex($key, $ttl, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function psetex($key, $ttl, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function setnx($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function del($key1, ...$otherKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key, ...$other_keys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function unlink($key, ...$other_keys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function multi($mode = Redis::MULTI)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pipeline()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }


    /**
     * {@inheritDoc}
     */
    public function exec()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function discard()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function watch($key, ...$other_keys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function unwatch()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function subscribe($channels, $callback)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function psubscribe($patterns, $callback)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function publish($channel, $message)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pubsub($cmd, ...$args)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function unsubscribe($channel, ...$other_channels)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function punsubscribe($pattern, ...$other_patterns)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function exists($key, ...$other_keys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function incr($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function incrByFloat($key, $increment)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function incrBy($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function decr($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function decrBy($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lPush($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function rPush($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lPushx($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function rPushx($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lPop($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function rPop($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function blPop($key, $timeout_or_key, ...$extra_args)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function brPop($key, $timeout_or_key, ...$extra_args)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lLen($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lSize($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lIndex($key, $index)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lGet($key, $index)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lSet($key, $index, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lRange($key, $start, $end)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lGetRange($key, $start, $end)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lTrim($key, $start, $stop)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function listTrim($key, $start, $stop)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lRem($key, $value, $count)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lRemove($key, $value, $count)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lInsert($key, $position, $pivot, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sAdd($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sRem($key, $member, ...$other_members)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sRemove($key, $member, ...$other_members)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sMove($srcKey, $dstKey, $member)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sIsMember($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sContains($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sCard($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sPop($key, $count = 1)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sRandMember($key, $count = 1)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sInter($key1, ...$otherKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sInterStore($dstKey, $key1, ...$otherKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sUnion($key1, ...$otherKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sUnionStore($dstKey, $key1, ...$otherKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sDiff($key1, ...$otherKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sDiffStore($dstKey, $key1, ...$otherKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sMembers($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sGetMembers($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sScan($key, &$iterator, $pattern = null, $count = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getSet($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function randomKey()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function select($dbIndex)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function move($key, $dbIndex)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function rename($srcKey, $dstKey)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function renameKey($srcKey, $dstKey)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function renameNx($srcKey, $dstKey)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function expire($key, $ttl)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pExpire($key, $ttl)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function setTimeout($key, $ttl)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function expireAt($key, $timestamp)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pExpireAt($key, $timestamp)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function keys($pattern)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getKeys($pattern)
    {
        return $this->keys($pattern);
    }

    /**
     * {@inheritDoc}
     */
    public function dbSize()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function auth($password)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function bgrewriteaof()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function slaveof($host = '127.0.0.1', $port = 6379)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function slowLog($arg, $option = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }


    /**
     * {@inheritDoc}
     */
    public function object($string = '', $key = '')
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function save()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function bgsave()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function lastSave()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function wait($numSlaves, $timeout)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function type($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function append($key, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getRange($key, $start, $end)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function substr($key, $start, $end)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function setRange($key, $offset, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function strlen($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function bitpos($key, $bit, $start = 0, $end = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getBit($key, $offset)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function setBit($key, $offset, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function bitCount($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function bitOp($operation, $retKey, $key1, ...$otherKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function flushDB($async = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function flushAll($async = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sort($key, $option = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function info($option = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function resetStat()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function ttl($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pttl($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function persist($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function mset(array $array)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getMultiple(array $keys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function mget(array $array)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function msetnx(array $array)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function rpoplpush($srcKey, $dstKey)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function brpoplpush($srcKey, $dstKey, $timeout)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zAdd(
        $key,
        $options,
        $score1,
        $value1 = null,
        $score2 = null,
        $value2 = null,
        $scoreN = null,
        $valueN = null
    ) {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRange($key, $start, $end, $withscores = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRem($key, $member1, ...$otherMembers)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zDelete($key, $member1, ...$otherMembers)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRevRange($key, $start, $end, $withscore = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRangeByScore($key, $start, $end, array $options = array())
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRevRangeByScore($key, $start, $end, array $options = array())
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRangeByLex($key, $min, $max, $offset = null, $limit = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRevRangeByLex($key, $min, $max, $offset = null, $limit = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zCount($key, $start, $end)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRemRangeByScore($key, $start, $end)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zDeleteRangeByScore($key, $start, $end)
    {
        return $this->zRemRangeByScore($key, $start, $end);
    }

    /**
     * {@inheritDoc}
     */
    public function zRemRangeByRank($key, $start, $end)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zDeleteRangeByRank($key, $start, $end)
    {
        return $this->zRemRangeByRank($key, $start, $end);
    }

    /**
     * {@inheritDoc}
     */
    public function zCard($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zSize($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zScore($key, $member)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRank($key, $member)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zRevRank($key, $member)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zIncrBy($key, $value, $member)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zUnionStore($output, $zSetKeys, array $weights = null, $aggregateFunction = 'SUM')
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zUnion($Output, $ZSetKeys, array $Weights = null, $aggregateFunction = 'SUM')
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zInterStore($output, $zSetKeys, array $weights = null, $aggregateFunction = 'SUM')
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zInter($Output, $ZSetKeys, array $Weights = null, $aggregateFunction = 'SUM')
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zScan($key, &$iterator, $pattern = null, $count = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function bzPopMax($key, $timeout_or_key, ...$extra_args)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function bzPopMin($key, $timeout_or_key, ...$extra_args)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zPopMax($key, $count = 1)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function zPopMin($key, $count = 1)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hSet($key, $hashKey, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hSetNx($key, $hashKey, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hGet($key, $hashKey)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hLen($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hDel($key, $hashKey1, ...$otherHashKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hKeys($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hVals($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hGetAll($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hExists($key, $hashKey)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hIncrBy($key, $hashKey, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hIncrByFloat($key, $field, $increment)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hMSet($key, $hashKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hMGet($key, $hashKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hScan($key, &$iterator, $pattern = null, $count = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function hStrLen($key, $member)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function geoadd($key, $lng, $lat, $member, ...$other_triples)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function geohash($key, $member, ...$other_members)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function geopos($key, $member, ...$other_members)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function geodist($key, $member1, $member2, $unit = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function georadius($key, $longitude, $latitude, $radius, $unit, array $options = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function georadiusbymember($key, $member, $radius, $units, array $options = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function config($cmd, $key, $value = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function eval($script, $args = array(), $numKeys = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function evaluate($script, $args = array(), $numKeys = 0)
    {
        return $this->eval($script, $args, $numKeys);
    }

    /**
     * {@inheritDoc}
     */
    public function evalSha($scriptSha, $args = array(), $numKeys = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function evaluateSha($scriptSha, $args = array(), $numKeys = 0)
    {
        return $this->evalSha($scriptSha, $args, $numKeys);
    }

    /**
     * {@inheritDoc}
     */
    public function script($cmd, ...$args)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getLastError()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function clearLastError()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function client($cmd, ...$args)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function _prefix($value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function _unserialize($value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function _serialize($value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function dump($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function restore($key, $ttl, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function migrate($host, $port, $key, $db, $timeout, $copy = false, $replace = false)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function time()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function scan(&$iterator, $pattern = null, $count = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pfAdd($key, array $elements)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pfCount($key)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function pfMerge($destKey, array $sourceKeys)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function rawCommand($cmd, ...$args)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getMode()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xAck($stream, $group, $messages)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xAdd($key, $id, $messages, $maxLen = 0, $isApproximate = false)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xClaim($key, $group, $consumer, $minIdleTime, $ids, $options = [])
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xDel($key, $ids)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xGroup($str_operation, $str_key = null, $str_arg1 = null, $str_arg2 = null, $str_arg3 = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xInfo($str_cmd, $str_key = null, $str_group = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xLen($stream)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xPending($stream, $group, $start = null, $end = null, $count = null, $consumer = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xRange($stream, $start, $end, $count = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xRead($streams, $count = null, $block = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xReadGroup($group, $consumer, $streams, $count = null, $block = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xRevRange($stream, $end, $start, $count = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function xTrim($str_key, $i_maxlen, $boo_approximate = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function sAddArray($key, array $values)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }
}
