<?php

namespace Experteam\ApiTestingBundle\Service\TestData;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class TestData implements TestDataInterface
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
        $this->filesDir = $parameterBag->get('kernel.project_dir') . '/tests/Data/';
    }

    /**
     * @param string $class
     * @param string $function
     * @param string $key
     * @return array|null
     */
    public function getValue(string $class, string $function, string $key): ?array
    {
        $filePath = $this->filesDir . str_replace(['\\', 'App/Tests/'], ['/', ''], $class) . '/' . ucfirst($function) . "/$key.json";

        if (!$this->filesystem->exists($filePath)) {
            return null;
        }

        $fileContents = file_get_contents($filePath);

        if ($fileContents === false) {
            return null;
        }

        return json_decode($fileContents, true);
    }
}
