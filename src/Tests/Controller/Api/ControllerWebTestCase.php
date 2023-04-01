<?php

namespace Experteam\ApiTestingBundle\Tests\Controller\Api;

use Experteam\ApiTestingBundle\Service\MockHttpClientInterface;
use Experteam\ApiTestingBundle\Service\TestData\TestData;
use Experteam\ApiTestingBundle\Utils\RedisData;
use Redis;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class ControllerWebTestCase extends WebTestCase
{
    /**
     * @var string
     */
    public string $testClass;

    /**
     * @var string
     */
    public string $testFunction;

    /**
     * @var KernelBrowser
     */
    public KernelBrowser $client;

    /**
     * @var ContainerInterface
     */
    public ContainerInterface $testContainer;

    /**
     * @var TestData|null
     */
    public ?TestData $testData;

    /**
     * @var bool
     */
    private bool $useRedisMock = false;

    /**
     * @var RedisData
     */
    private RedisData $redisData;

    /**
     * @return bool
     */
    public function isUseRedisMock(): bool
    {
        return $this->useRedisMock;
    }

    /**
     * @param RedisData $redisData
     */
    public function setUseRedisMock(RedisData $redisData): void
    {
        $this->useRedisMock = true;
        $this->redisData = $redisData;
    }

    /**
     * @param array|null $mockResponses
     * @return MockHttpClient
     */
    private function getMockHttpClient(?array $mockResponses): MockHttpClient
    {
        $responses = [];

        if (!is_null($mockResponses)) {
            foreach ($mockResponses as $mockResponse) {
                $responses[] = new MockResponse(json_encode($mockResponse), [
                    'http_code' => 200,
                    'response_headers' => [
                        'Content-Type: application/json'
                    ]
                ]);
            }
        }

        return new MockHttpClient($responses);
    }

    /**
     * @param string $testClass
     * @param string $testFunction
     * @param string $token
     */
    protected function init(string $testClass, string $testFunction, string $token = '81496|6dKDes8Zcieq6ZnX1ytb2GAxop957X1HbPuczNqG')
    {
        $this->testClass = $testClass;
        $this->testFunction = $testFunction;
        $this->client = static::createClient();

        $this->client->setServerParameters([
            'HTTP_HOST' => 'localhost:8080',
            'HTTP_AUTHORIZATION' => "Bearer $token"
        ]);

        $this->testContainer = $this->client->getContainer();
        $this->testData = $this->testContainer->get('api_testing.test_data');
        $mockResponses = $this->testData->getValue($this->testClass, $this->testFunction, 'mock-responses');
        $this->testContainer->set(MockHttpClientInterface::class, $this->getMockHttpClient($mockResponses));

        if (!$this->isUseRedisMock()) {
            $this->testContainer->set(Redis::class, $this->testContainer->get('api_testing.mock_redis'));
        } else {
            $redisMock = $this->createMock(Redis::class);
            $this->testContainer->get('api_testing.redis_mock')->init($redisMock, $this->redisData);
            $this->testContainer->set(Redis::class, $redisMock);
        }
    }

    protected function commonAssertions(int $statusCode = 200)
    {
        $this->assertResponseStatusCodeSame($statusCode);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($this->client->getResponse()->getContent());
    }

    protected function assertEqualResponses()
    {
        $response = $this->testData->getValue($this->testClass, $this->testFunction, 'response');
        $this->assertEquals(json_encode($response), $this->client->getResponse()->getContent());
    }

    /**
     * @param array $array
     * @param array $keys
     * @param string|null $keysType
     */
    protected function assertArrayHasKeys(array $array, array $keys, string $keysType = null)
    {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $array);

            if ($keysType === 'int') {
                $this->assertIsInt($array[$key]);
            }
        }
    }

    /**
     * @param array $expectedResponse
     * @param array $actualResponse
     * @param array $keys
     */
    protected function assertEqualPartialResponses(array $expectedResponse, array $actualResponse, array $keys)
    {
        foreach ($keys as $key) {
            unset($actualResponse[$key]);
        }

        $this->assertEquals($expectedResponse, $actualResponse);
    }
}
