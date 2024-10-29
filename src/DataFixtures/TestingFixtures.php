<?php

namespace Experteam\ApiTestingBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TestingFixtures extends Fixture
{
    protected string $dataFileName = '';
    protected string $deserializeType = '';
    protected array $deserializeContext = [];
    protected bool $oneFlush = true;

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly SerializerInterface   $serializer
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        if (!empty($this->dataFileName)) {
            $fileName = $this->parameterBag->get('app.files.directory.fixtures') . "/testing/$this->dataFileName.json";

            if (file_exists($fileName)) {
                $json = file_get_contents($fileName);

                if ($json !== false) {
                    $data = json_decode($json, true);

                    if (!is_null($data) && !empty($this->deserializeType)) {
                        foreach ($data as $datum) {
                            $object = $this->serializer->deserialize(json_encode($datum), $this->deserializeType, 'json', $this->deserializeContext);

                            if ($object instanceof $this->deserializeType) {
                                $manager->persist($this->updateObject($object));

                                if (!$this->oneFlush) {
                                    $manager->flush();
                                }
                            }
                        }

                        if ($this->oneFlush) {
                            $manager->flush();
                        }
                    }
                }
            }
        }
    }

    protected function updateObject(mixed $object): mixed
    {
        return $object;
    }
}
