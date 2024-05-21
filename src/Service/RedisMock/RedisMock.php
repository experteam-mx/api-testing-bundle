<?php

namespace Experteam\ApiTestingBundle\Service\RedisMock;

use Experteam\ApiTestingBundle\Utils\RedisData;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class RedisMock implements RedisMockInterface
{
    /**
     * @var string
     */
    private string $filesDir;

    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->filesystem = new Filesystem();
        $this->filesDir = $parameterBag->get('kernel.project_dir') . '/vendor/experteam/api-testing-bundle/data/redis-mock';
    }

    /**
     * @param string $method
     * @param string $key
     * @param string|null $hashKey
     * @return string|false
     */
    private function getValue(string $method, string $key, ?string $hashKey = null): string|false
    {
        $filePath = "$this->filesDir/$method/" . str_replace([':', '|'], ['_', '-'], $key);

        if (!is_null($hashKey)) {
            $filePath .= '/' . str_replace(':', '_', $hashKey);
        }

        $filePath .= '.json';

        if (!$this->filesystem->exists($filePath)) {
            return false;
        }

        return file_get_contents($filePath);
    }

    /**
     * @param MockObject $redisMock
     * @param RedisData $redisData
     * @return void
     */
    public function init(MockObject $redisMock, RedisData $redisData): void
    {
        $method = '';
        $valueMap = [];

        foreach ($redisData->getGet() as $redisGet) {
            $method = 'get';
            $key = $redisGet->key;
            $value = $this->getValue($method, $key);

            if ($value !== false) {
                $valueMap[] = [$key, $value];
            }
        }

        if (!empty($valueMap)) {
            $redisMock->method($method)
                ->willReturnMap($valueMap);

            $valueMap = [];
        }

        foreach ($redisData->getHget() as $redisHget) {
            $method = 'hGet';
            $key = $redisHget->key;
            $hashKey = $redisHget->hashKey;
            $value = $this->getValue($method, $key, $hashKey);

            if ($value !== false) {
                $valueMap[] = [$key, $hashKey, $value];
            }
        }

        if (!empty($valueMap)) {
            $redisMock->method($method)
                ->willReturnMap($valueMap);

            $valueMap = [];
        }

        foreach ($redisData->getHgetall() as $redisHgetall) {
            $method = 'hGetAll';
            $key = $redisHgetall->key;
            $value = $this->getValue($method, $key);

            if ($value !== false) {
                $valueMap[] = [$key, $value];
            }
        }

        if (!empty($valueMap)) {
            $redisMock->method($method)
                ->willReturnMap($valueMap);
            $valueMap = [];
        }

        foreach ($redisData->getKeys() as $redisKey) {
            $method = 'keys';
            $key = $redisKey->pattern;
            $value = json_decode($this->getValue($method, $key),true);

            if ($value !== false) {
                $valueMap[] = [$key, $value];
            }
        }

        if (!empty($valueMap)) {
            $redisMock->method($method)
                ->willReturnMap($valueMap);
            $valueMap = [];
        }

        foreach ($redisData->getIncr() as $redisIncr) {
            $method = 'incr';
            $key = $redisIncr->key;
            $value = $this->getValue($method, $key);

            if ($value !== false) {
                $valueMap[] = [$key, (int)$value+1];
            }
        }

        if (!empty($valueMap)) {
            $redisMock->method($method)
                ->willReturnMap($valueMap);


        }
    }
}
