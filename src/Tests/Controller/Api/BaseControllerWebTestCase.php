<?php

namespace Experteam\ApiTestingBundle\Tests\Controller\Api;

use Experteam\ApiTestingBundle\Utils\Literal;
use Experteam\ApiTestingBundle\Utils\RedisData;
use Experteam\ApiTestingBundle\Utils\RedisExists;
use Experteam\ApiTestingBundle\Utils\RedisGet;
use Experteam\ApiTestingBundle\Utils\RedisHget;
use Experteam\ApiTestingBundle\Utils\RedisHgetall;

class BaseControllerWebTestCase extends ControllerWebTestCase
{
    private string $baseUri = '/api';

    private array $redisGetData = [
        [Literal::KEY => 'security.token:81496|6dKDes8Zcieq6ZnX1ytb2GAxop957X1HbPuczNqG']
    ];

    private array $redisHgetData = [];

    private array $redisHgetallData = [];

    private array $redisExistsData = [];

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function setBaseUri(string $baseUri): void
    {
        $this->baseUri = $baseUri;
    }

    public function getRedisGetData(): array
    {
        return $this->redisGetData;
    }

    public function setRedisGetData(array $redisGetData): void
    {
        $this->redisGetData = $redisGetData;
    }

    public function getRedisHgetData(): array
    {
        return $this->redisHgetData;
    }

    public function setRedisHgetData(array $redisHgetData): void
    {
        $this->redisHgetData = $redisHgetData;
    }

    public function getRedisHgetallData(): array
    {
        return $this->redisHgetallData;
    }

    public function setRedisHgetallData(array $redisHgetallData): void
    {
        $this->redisHgetallData = $redisHgetallData;
    }

    public function getRedisExistsData(): array
    {
        return $this->redisExistsData;
    }

    public function setRedisExistsData(array $redisExistsData): void
    {
        $this->redisExistsData = $redisExistsData;
    }

    public function minUnitTest(string $testClass, string $testFunction, string $method, string $uri, bool $getRequest = false, array $keysAndTypes = [], bool $assertEqualPartialResponses = false, ?string $token = null, ?string $appKey = null, bool $getFiles = false): array
    {
        $this->mockRedis();

        if (is_null($token) && is_null($appKey)) {
            $this->init($testClass, $testFunction);
        } elseif (!is_null($token)) {
            $this->init($testClass, $testFunction, $token);
        } else {
            $this->init($testClass, $testFunction, null, $appKey);
        }

        $request = ($getRequest ? $this->testData->getValue($testClass, $testFunction, 'request') : []);

        if ($method === 'GET' || $getFiles) {
            $files = ($getFiles ? ($this->testData->getFiles($testClass, $testFunction) ?? []) : []);
            $this->client->request($method, "$this->baseUri/$uri", $request, $files);
        } else {
            $this->client->jsonRequest($method, "$this->baseUri/$uri", $request);
        }

        $this->commonAssertions();
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKeys($response, ['status', 'data']);
        $this->assertEquals('success', $response['status']);
        $data = $response['data'];
        $this->assertIsArray($data);

        if (!empty($keysAndTypes)) {
            $keys = array_keys($keysAndTypes);
            $this->assertArrayHasKeys($data, $keys);

            foreach ($keysAndTypes as $key => $type) {
                $assertIsType = 'assertIs' . ucfirst($type);

                if (method_exists($this, $assertIsType)) {
                    $this->$assertIsType($data[$key]);
                }
            }

            if ($assertEqualPartialResponses) {
                $partialResponse = ($this->testData->getValue($testClass, $testFunction, 'partial-response') ?? []);
                $this->assertEqualPartialResponses($partialResponse, $data, $keys);
            }
        }

        return $data;
    }

    public function mockRedis(): void
    {
        $get = $hget = $hgetall = $exists = [];

        foreach ($this->redisGetData as $getData) {
            $redisGet = new RedisGet();
            $redisGet->key = $getData[Literal::KEY];
            $get[] = $redisGet;
        }

        foreach ($this->redisHgetData as $hgetData) {
            $redisHget = new RedisHget();
            $redisHget->key = $hgetData[Literal::KEY];
            $redisHget->hashKey = $hgetData[Literal::HASH_KEY];
            $hget[] = $redisHget;
        }

        foreach ($this->redisHgetallData as $hgetallData) {
            $redisHgetall = new RedisHgetall();
            $redisHgetall->key = $hgetallData[Literal::KEY];
            $hgetall[] = $redisHgetall;
        }

        foreach ($this->redisExistsData as $existsData) {
            $redisExists = new RedisExists();
            $redisExists->key = $existsData[Literal::KEY];
            $exists[] = $redisExists;
        }

        $redisData = new RedisData();
        $redisData->setGet(...$get);
        $redisData->setHget(...$hget);
        $redisData->setHgetall(...$hgetall);
        $redisData->setExists(...$exists);
        $this->setUseRedisMock($redisData);
    }

    public function customCommonAssertions(array &$resource, bool $includeId = false): void
    {
        $this->assertIsArray($resource);

        $keys = [Literal::CREATED_AT, Literal::UPDATED_AT];

        if ($includeId) {
            $keys[] = Literal::ID;
        }

        $this->assertArrayHasKeys($resource, $keys);

        $this->assertIsString($resource[Literal::CREATED_AT]);
        $this->assertIsString($resource[Literal::UPDATED_AT]);

        unset($resource[Literal::CREATED_AT]);
        unset($resource[Literal::UPDATED_AT]);

        if ($includeId) {
            $this->assertIsInt($resource[Literal::ID]);
            unset($resource[Literal::ID]);
        }
    }

    public function customAssertEqualPartialResponses(array $data): void
    {
        $partialResponse = ($this->testData->getValue($this->testClass, $this->testFunction, 'partial-response') ?? []);
        $this->assertEquals($partialResponse, $data);
    }

    public function countryCommonCustomAssertions(array &$resource): void
    {
        $keys = [Literal::LOCATION_TYPE, Literal::UNIT];
        $this->assertArrayHasKeys($resource, $keys);
        $this->assertIsArray($resource[Literal::LOCATION_TYPE]);
        $this->assertIsArray($resource[Literal::UNIT]);

        $keys = [Literal::CREATED_AT, Literal::UPDATED_AT];
        $this->assertArrayHasKeys($resource[Literal::LOCATION_TYPE], $keys);
        $this->assertArrayHasKeys($resource[Literal::UNIT], $keys);
        $this->assertIsString($resource[Literal::LOCATION_TYPE][Literal::CREATED_AT]);
        $this->assertIsString($resource[Literal::LOCATION_TYPE][Literal::UPDATED_AT]);
        $this->assertIsString($resource[Literal::UNIT][Literal::CREATED_AT]);
        $this->assertIsString($resource[Literal::UNIT][Literal::UPDATED_AT]);

        unset($resource[Literal::LOCATION_TYPE][Literal::CREATED_AT]);
        unset($resource[Literal::LOCATION_TYPE][Literal::UPDATED_AT]);
        unset($resource[Literal::UNIT][Literal::CREATED_AT]);
        unset($resource[Literal::UNIT][Literal::UPDATED_AT]);
    }
}
