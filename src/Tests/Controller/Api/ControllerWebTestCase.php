<?php

namespace Experteam\ApiTestingBundle\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ControllerWebTestCase extends WebTestCase
{
    /**
     * @param array $mockResponses
     * @return MockHttpClient
     */
    private function getMockHttpClient(array $mockResponses): MockHttpClient
    {
        $responses = [];

        foreach ($mockResponses as $mockResponse) {
            $responses[] = new MockResponse(json_encode($mockResponse), [
                'http_code' => 200,
                'response_headers' => [
                    'Content-Type: application/json'
                ]
            ]);
        }

        return new MockHttpClient($responses);
    }

    /**
     * @param array $mockResponses
     * @return KernelBrowser
     */
    protected function getClient(array $mockResponses): KernelBrowser
    {
        $client = self::createClient();

        $client->setServerParameters([
            'HTTP_HOST' => 'localhost:8080',
            'HTTP_AUTHORIZATION' => 'Bearer 81496|6dKDes8Zcieq6ZnX1ytb2GAxop957X1HbPuczNqG'
        ]);

        $client->getContainer()->set(HttpClientInterface::class, $this->getMockHttpClient($mockResponses));
        return $client;
    }

    protected function commonAssertions(KernelBrowser $client)
    {
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    /**
     * @param array $response
     * @param KernelBrowser $client
     */
    protected function assertEqualResponses(array $response, KernelBrowser $client)
    {
        $this->assertEquals(json_encode($response), $client->getResponse()->getContent());
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

            if (!is_null($keysType)) {
                switch ($keysType) {
                    case 'int':
                        $this->assertIsInt($array[$key]);
                        break;
                }
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
