<?php

namespace Experteam\ApiTestingBundle\Service\RedisMock;

use Experteam\ApiTestingBundle\Utils\RedisData;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class RedisMock implements RedisMockInterface
{
    private string $filesDir;

    private Filesystem $filesystem;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->filesystem = new Filesystem();
        $this->filesDir = $parameterBag->get('kernel.project_dir') . '/vendor/experteam/api-testing-bundle/data/redis-mock';
    }

    public function init(MockObject $redisMock, RedisData $redisData): void
    {
        $methodValueMap = [];

        foreach ($redisData->getGet() as $redisGet) {
            $method = 'get';
            $key = $redisGet->key;
            $value = $this->getValue($method, $key);

            if ($value !== false) {
                if (!isset($methodValueMap[$method])) {
                    $methodValueMap[$method] = [];
                }

                $methodValueMap[$method][] = [$key, $value];
            }
        }

        foreach ($redisData->getHget() as $redisHget) {
            $method = 'hGet';
            $key = $redisHget->key;
            $hashKey = $redisHget->hashKey;
            $value = $this->getValue($method, $key, $hashKey);

            if ($value !== false) {
                if (!isset($methodValueMap[$method])) {
                    $methodValueMap[$method] = [];
                }

                $methodValueMap[$method][] = [$key, $hashKey, $value];
            }
        }

        foreach ($redisData->getHgetall() as $redisHgetall) {
            $method = 'hGetAll';
            $key = $redisHgetall->key;
            $value = $this->getValue($method, $key);

            if ($value !== false) {
                if (!isset($methodValueMap[$method])) {
                    $methodValueMap[$method] = [];
                }

                $methodValueMap[$method][] = [$key, json_decode($value, true)];
            }
        }

        foreach ($redisData->getKeys() as $redisKey) {
            $method = 'keys';
            $key = $redisKey->pattern;
            $value = $this->getValue($method, $key);

            if ($value !== false) {
                if (!isset($methodValueMap[$method])) {
                    $methodValueMap[$method] = [];
                }

                $methodValueMap[$method][] = [$key, json_decode($value, true)];
            }
        }

        foreach ($redisData->getIncr() as $redisIncr) {
            $method = 'incr';
            $key = $redisIncr->key;
            $value = $this->getValue($method, $key);

            if ($value !== false) {
                if (!isset($methodValueMap[$method])) {
                    $methodValueMap[$method] = [];
                }

                $methodValueMap[$method][] = [$key, intval($value) + 1];
            }
        }

        if (!empty($methodValueMap)) {
            foreach ($methodValueMap as $method => $valueMap) {
                $redisMock->method($method)
                    ->willReturnMap($valueMap);
            }
        }
    }

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
}
