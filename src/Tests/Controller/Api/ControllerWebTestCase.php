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
     * @var bool
     */
    private bool $contentTypeIsJson = true;

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
                $body = $mockResponse;
                $info = ['http_code' => 200];

                if ($this->contentTypeIsJson) {
                    $body = json_encode($mockResponse);
                    $info['response_headers'] = ['Content-Type: application/json'];
                }

                $responses[] = new MockResponse($body, $info);
            }
        }

        return new MockHttpClient($responses);
    }

    /**
     * @return bool
     */
    public function isContentTypeIsJson(): bool
    {
        return $this->contentTypeIsJson;
    }

    /**
     * @param bool $contentTypeIsJson
     */
    public function setContentTypeIsJson(bool $contentTypeIsJson): void
    {
        $this->contentTypeIsJson = $contentTypeIsJson;
    }

    /**
     * @param string $testClass
     * @param string $testFunction
     * @param string $token
     * @return void
     */
    protected function init(string $testClass, string $testFunction, ?string $token = '81496|6dKDes8Zcieq6ZnX1ytb2GAxop957X1HbPuczNqG', ?string $appkey = null): void
    {
        $this->testClass = $testClass;
        $this->testFunction = $testFunction;
        $this->client = static::createClient();
        $serve = ['HTTP_HOST' => 'localhost:8080'];

        if(!is_null($token))
            $serve['HTTP_AUTHORIZATION'] = "Bearer $token";
        elseif (!is_null($appkey))
            $serve['HTTP_APPKEY'] = $appkey;

        $this->client->setServerParameters($serve);
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

    /**
     * @param int $statusCode
     * @return void
     */
    protected function commonAssertions(int $statusCode = 200): void
    {
        $this->assertResponseStatusCodeSame($statusCode);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($this->client->getResponse()->getContent());
    }

    /**
     * @return void
     */
    protected function assertEqualResponses(): void
    {
        $response = $this->testData->getValue($this->testClass, $this->testFunction, 'response');
        $this->assertEquals(json_encode($response), $this->client->getResponse()->getContent());
    }

    /**
     * @param array $array
     * @param array $keys
     * @param string|null $keysType
     * @return void
     */
    protected function assertArrayHasKeys(array $array, array $keys, string $keysType = null): void
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
     * @return void
     */
    protected function assertEqualPartialResponses(array $expectedResponse, array $actualResponse, array $keys): void
    {
        foreach ($keys as $key) {
            unset($actualResponse[$key]);
        }

        $this->assertEquals($expectedResponse, $actualResponse);
    }
}
