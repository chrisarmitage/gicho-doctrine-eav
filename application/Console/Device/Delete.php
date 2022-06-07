<?php

namespace Application\Console\Device;

use Core\AttributeType;
use Core\Device;
use Core\DeviceAttribute;
use Core\DeviceIdentifier;
use Doctrine\ORM\EntityManager;

class Delete
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

        $repository = $this->entityManager->getRepository(Device::class);
        $device = $repository->findOneBy(['name' => $name]);

        $this->entityManager->remove($device);
        $this->entityManager->flush();

        echo "Removed Device with ID " . $device->id()->deviceUuid() . "\n";
    }
}
