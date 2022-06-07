<?php

namespace Application\Console\Type;

use Core\AttributeType;
use Doctrine\ORM\EntityManager;

class Create
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

        $attributeType = new AttributeType();
        $attributeType->setName($name);

        $this->entityManager->persist($attributeType);
        $this->entityManager->flush();

        echo "Created AttributeType with ID " . $attributeType->getId() . "\n";
    }
}
