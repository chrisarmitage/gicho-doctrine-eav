<?php

namespace Application\Console\Type;

use Core\AttributeType;
use Doctrine\ORM\EntityManager;

class Index
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
        $repository = $this->entityManager->getRepository(AttributeType::class);
        $types = $repository->findAll();

        foreach ($types as $type) {
            echo sprintf("%s: %s\n", $type->getId(), $type->name());
        }
    }
}
