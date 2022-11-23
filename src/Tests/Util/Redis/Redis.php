<?php

namespace Experteam\ApiTestingBundle\Tests\Util\Redis;

use Experteam\ApiRedisBundle\Service\RedisClient\RedisClientInterface;
use Symfony\Component\String\ByteString;

class Redis
{
    /**
     * @var Redis
     */
    private static Redis $instance;

    /**
     * @var string
     */
    private string $token;

    /**
     * @return array
     */
    private function getTokenData(): array
    {
        $tokenDataJson = file_get_contents(__DIR__ . '/files/token_data.json');
        return json_decode($tokenDataJson, true);
    }

    /**
     * @return Redis
     */
    public static function getInstance(): Redis
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param RedisClientInterface $redisClient
     * @return string
     */
    public function createToken(RedisClientInterface $redisClient): string
    {
        if (!isset($this->token)) {
            $id = rand(1, 100000);
            $plainTextToken = ByteString::fromRandom(40)->toString();
            $this->token = "$id|$plainTextToken";
            $key = "security.token:{$this->token}";

            if ($redisClient->exists($key) === 0) {
                $redisClient->setex($key, 1800, $this->getTokenData());
            }
        }

        return $this->token;
    }
}
