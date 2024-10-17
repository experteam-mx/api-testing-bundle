<?php

namespace Experteam\ApiTestingBundle\Service\TestData;

interface TestDataInterface
{
    public function getValue(string $class, string $function, string $key): ?array;

    public function getFiles(string $class, string $function): ?array;
}
