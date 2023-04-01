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
}
