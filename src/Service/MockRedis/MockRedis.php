<?php

namespace Experteam\ApiTestingBundle\Service\MockRedis;

use Redis;
use Snc\RedisBundle\DependencyInjection\Configuration\RedisDsn;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class MockRedis extends Redis
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
        parent::__construct();
        $this->filesystem = new Filesystem();
        $this->filesDir = $parameterBag->get('kernel.project_dir') . '/vendor/experteam/api-testing-bundle/data/redis-mock';
    }

    /**
     * @param string $function
     * @param string $key
     * @param string|null $hashKey
     * @return string|false
     */
    private function getValue(string $function, string $key, ?string $hashKey = null): string|false
    {
        $filePath = "{$this->filesDir}/$function/" . str_replace([':', '|'], ['_', '-'], $key);

        if (!is_null($hashKey)) {
            $filePath .= '/' . str_replace(':', '_', $hashKey);
        }

        $filePath .= '.json';

        if (!$this->filesystem->exists($filePath)) {
            return false;
        }

        return file_get_contents($filePath);
    }

    public function get($key)
    {
        return $this->getValue(__FUNCTION__, $key);
    }

    public function hGet($key, $hashKey)
    {
        return $this->getValue(__FUNCTION__, $key, $hashKey);
    }

    public function hGetAll($key)
    {
        $value = $this->getValue(__FUNCTION__, $key);
        return (($value === false) ? [] : json_decode($value, true));
    }

    public function incr($key)
    {
        $dsn = new RedisDsn($_ENV['REDIS_URL'] ?? '');
        parent::connect($dsn->getHost(), $dsn->getPort(), 5, $dsn->getPersistentId(), 5, 5);
        return parent::incr($key);
    }

    public function keys($pattern)
    {
        $keys = json_decode($this->getValue(__FUNCTION__, __FUNCTION__), true)[__FUNCTION__] ?? [];

        return array_filter($keys, function ($k) use ($pattern) {
            $pattern = preg_replace_callback('/([^*])/', function($m) {
                return preg_quote($m[0], '/');
            }, $pattern);
            $pattern = str_replace('*', '.*', $pattern);
            return (bool) preg_match('/^' . $pattern . '$/i', $k);
        });
    }

    public function set($key, $value, $timeout = null)
    {
        //Do nothing
    }

    public function hSet($key, $hashKey, $value)
    {
        //Do nothing
    }

    public function expire($key, $ttl)
    {
        //Do nothing
    }
}
