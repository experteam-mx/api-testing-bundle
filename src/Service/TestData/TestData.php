<?php

namespace Experteam\ApiTestingBundle\Service\TestData;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TestData implements TestDataInterface
{
    private string $filesDir;
    private Filesystem $filesystem;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->filesystem = new Filesystem();
        $this->filesDir = $parameterBag->get('kernel.project_dir') . '/tests/Data/';
    }

    public function getValue(string $class, string $function, string $key): ?array
    {
        $filePath = "{$this->getTestPath($class, $function)}/$key.json";

        if (!$this->filesystem->exists($filePath)) {
            return null;
        }

        $fileContents = file_get_contents($filePath);

        if ($fileContents === false) {
            return null;
        }

        return json_decode($fileContents, true);
    }

    private function getTestPath(string $class, string $function): string
    {
        return $this->filesDir . str_replace(['\\', 'App/Tests/'], ['/', ''], $class) . '/' . ucfirst($function);
    }

    public function getFiles(string $class, string $function): ?array
    {
        $filesPath = "{$this->getTestPath($class, $function)}/files";

        if (!$this->filesystem->exists($filesPath)) {
            return null;
        }

        $finder = new Finder();
        $finder->files()->in($filesPath);

        if (!$finder->hasResults()) {
            return null;
        }

        $files = [];

        foreach ($finder as $file) {
            $files[$file->getFilenameWithoutExtension()] = new UploadedFile($file->getRealPath(), $file->getFilename(), mime_content_type($file->getRealPath()));
        }

        return $files;
    }
}
