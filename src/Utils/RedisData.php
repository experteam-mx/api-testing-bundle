<?php

namespace Experteam\ApiTestingBundle\Utils;

class RedisData
{
    /**
     * @var RedisGet[]
     */
    private array $get = [];

    /**
     * @var RedisHget[]
     */
    private array $hget = [];

    /**
     * @var RedisHgetall[]
     */
    private array $hgetall = [];

    /**
     * @var RedisKeys[]
     */
    private array $keys = [];

    /**
     * @var RedisIncr[]
     */
    private array $incr = [];

    /**
     * @var RedisExists[]
     */
    private array $exists = [];

    /**
     * @return RedisGet[]
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @param RedisGet ...$get
     * @return void
     */
    public function setGet(RedisGet ...$get): void
    {
        $this->get = $get;
    }

    /**
     * @return RedisHget[]
     */
    public function getHget(): array
    {
        return $this->hget;
    }

    /**
     * @param RedisHget ...$hget
     * @return void
     */
    public function setHget(RedisHget ...$hget): void
    {
        $this->hget = $hget;
    }

    /**
     * @return RedisHgetall[]
     */
    public function getHgetall(): array
    {
        return $this->hgetall;
    }

    /**
     * @param RedisHgetall ...$hgetall
     * @return void
     */
    public function setHgetall(RedisHgetall ...$hgetall): void
    {
        $this->hgetall = $hgetall;
    }

    /**
     * @return RedisKeys[]
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * @param RedisKeys ...$keys
     * @return void
     */
    public function setKeys(RedisKeys ...$keys): void
    {
        $this->keys = $keys;
    }

    /**
     * @return RedisIncr[]
     */
    public function getIncr(): array
    {
        return $this->incr;
    }

    /**
     * @param RedisIncr ...$incr
     * @return void
     */
    public function setIncr(RedisIncr ...$incr): void
    {
        $this->incr = $incr;
    }

    /**
     * @return RedisExists[]
     */
    public function getExists(): array
    {
        return $this->exists;
    }

    /**
     * @param RedisExists ...$exists
     * @return void
     */
    public function setExists(RedisExists ...$exists): void
    {
        $this->exists = $exists;
    }
}
