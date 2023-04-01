<?php

namespace Experteam\ApiTestingBundle\Service\RedisMock;

use Experteam\ApiTestingBundle\Utils\RedisData;
use PHPUnit\Framework\MockObject\MockObject;

interface RedisMockInterface
{
    /**
     * @param MockObject $redisMock
     * @param RedisData $redisData
     * @return void
     */
    public function init(MockObject $redisMock, RedisData $redisData): void;
}
