<?php

namespace Application\Console\Device;

use Core\AttributeType;
use Core\Device;
use Core\DeviceAttribute;
use Core\DeviceIdentifier;
use Doctrine\ORM\EntityManager;

class Update
{
    protected EntityManager $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute($parsedTokens)
    {
        $name = $parsedTokens['name'] ?? null;

        if ($name === null) {
            throw new \Exception('Missing param');
        }

        $attributeRepository = $this->entityManager->getRepository(AttributeType::class);
        /** @var AttributeType[] $allAttributeTypes */
        $allAttributeTypes = $attributeRepository->findAll();

        $repository = $this->entityManager->getRepository(Device::class);
        /** @var Device $device */
        $device = $repository->findOneBy(['name' => $name]);

        foreach ($allAttributeTypes as $attributeType) {
            if (array_key_exists($attributeType->name(), $parsedTokens)) {
                $attribute = new DeviceAttribute($parsedTokens[$attributeType->name()], $attributeType);
                $device->setAttribute($attribute);
            }
        }

        $this->entityManager->persist($device);
        $this->entityManager->flush();

        echo "Updated Device with ID " . $device->id()->deviceUuid() . "\n";
        echo "Device: {$device->name()}" . PHP_EOL;
        /** @var DeviceAttribute $attribute */
        foreach ($device->attributes() as $attribute) {
            echo "  {$attribute->type()->name()}: {$attribute->value()}\n";
        }
    }
}
