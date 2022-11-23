<?php

namespace Experteam\ApiTestingBundle\Service\MockRedis;

use Redis;
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

    public function __construct()
    {
        parent::__construct();
        $this->filesDir = __DIR__ . '/files';
        $this->filesystem = new Filesystem();
    }

    /**
     * @param string $function
     * @param string $key
     * @param string|null $hashKey
     * @return string|false
     */
    private function getValue(string $function, string $key, ?string $hashKey = null)
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
}
