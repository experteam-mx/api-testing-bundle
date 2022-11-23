<?php

namespace Experteam\ApiTestingBundle\Service\MockRedisClient;

use Experteam\ApiRedisBundle\Service\RedisClient\RedisClientInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class MockRedisClient implements RedisClientInterface
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
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->filesDir = __DIR__ . '/files';
        $this->filesystem = new Filesystem();
        $this->serializer = $serializer;
    }

    /**
     * @param string $function
     * @param string $key
     * @return string|null
     */
    private function getValue(string $function, string $key): ?string
    {
        $filePath = "{$this->filesDir}/$function/" . str_replace([':', '|'], ['_', '-'], $key) . '.json';

        if (!$this->filesystem->exists($filePath)) {
            return null;
        }

        $fileContents = file_get_contents($filePath);
        return (($fileContents === false) ? null : $fileContents);
    }

    /**
     * @param string $value
     * @param string|null $objectType
     * @param bool $assoc
     * @return mixed
     */
    private function deserialize(string $value, ?string $objectType = null, bool $assoc = false)
    {
        if (is_null($objectType)) {
            $value = json_decode($value, $assoc);
        } else {
            $value = $this->serializer->deserialize($value, $objectType, 'json');
        }

        return $value;
    }

    public function set(string $key, $data, bool $serialize = true, array $serializeGroups = null)
    {
        // TODO: Implement set() method.
    }

    public function get(string $key, $objectType = null, $assoc = false)
    {
        $value = $this->getValue(__FUNCTION__, $key);
        return (is_null($value) ? null : $this->deserialize($value, $objectType, $assoc));
    }

    public function hset(string $key, $field, $data, bool $serialize = true, array $serializeGroups = null)
    {
        // TODO: Implement hset() method.
    }

    public function hget(string $key, $field, $objectType = null, $assoc = false)
    {
        // TODO: Implement hget() method.
    }

    public function hmset(string $key, array $data)
    {
        // TODO: Implement hmset() method.
    }

    public function hgetall(string $key)
    {
        // TODO: Implement hgetall() method.
    }

    public function expire(string $key, int $seconds)
    {
        // TODO: Implement expire() method.
    }

    public function setex(string $key, int $seconds, $data, bool $serialize = true, array $serializeGroups = null)
    {
        // TODO: Implement setex() method.
    }

    public function del($keys)
    {
        // TODO: Implement del() method.
    }

    public function keys(string $pattern = null)
    {
        // TODO: Implement keys() method.
    }

    public function hdel(string $key, array $fields)
    {
        // TODO: Implement hdel() method.
    }

    public function incr(string $key)
    {
        // TODO: Implement incr() method.
    }

    public function command(string $commandID, array $arguments = []): array
    {
        // TODO: Implement command() method.
        return [];
    }

    public function exists(string $key): int
    {
        // TODO: Implement exists() method.
        return -1;
    }
}
