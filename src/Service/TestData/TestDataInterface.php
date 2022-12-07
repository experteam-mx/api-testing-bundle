<?php

namespace Experteam\ApiTestingBundle\Service\TestData;

interface TestDataInterface
{
    /**
     * @param string $class
     * @param string $function
     * @param string $key
     * @return array|null
     */
    public function getValue(string $class, string $function, string $key): ?array;
}
