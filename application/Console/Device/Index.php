<?php

namespace Application\Console\Device;

use Core\AttributeType;
use Core\Device;
use Core\DeviceAttribute;
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
        $filter = $parsedTokens['filter'] ?? null;
        $value = $parsedTokens['value'] ?? null;

        if ($filter !== null && $value !== null) {
            $dql = /** @lang DQL */ "SELECT d FROM Core\Device d JOIN d.attributes da JOIN da.type dat WHERE dat.name = ?1 AND da.value = ?2";

            /** @var Device[] $devices */
            $devices = $this->entityManager->createQuery($dql)
                ->setParameter(1, $filter)
                ->setParameter(2, $value)
                ->getResult();
        } else {
            $repository = $this->entityManager->getRepository(Device::class);

            /** @var Device[] $devices */
            $devices = $repository->findAll();
        }

        $attributeRepository = $this->entityManager->getRepository(AttributeType::class);
        /** @var AttributeType[] $allAttributeTypes */
        $allAttributeTypes = $attributeRepository->findAll();

        /**
         * Work out the table dimensions
         */
        $maxColumnWidths = [
            'name' => strlen('name'),
        ];

        foreach ($allAttributeTypes as $attributeType) {
            $maxColumnWidths[$attributeType->name()] = strlen($attributeType->name());
        }

        foreach ($devices as $device) {
            $maxColumnWidths['name'] = max(
                $maxColumnWidths['name'],
                strlen($device->name())
            );

            foreach ($device->attributes() as $attribute) {
                $maxColumnWidths[$attribute->type()->name()] = max(
                    $maxColumnWidths[$attribute->type()->name()],
                    strlen($attribute->value())
                );
            }
        }

        /**
         * Echo the table
         */
        echo '|';
        foreach ($maxColumnWidths as $columnName => $columnWidth) {
            echo ' ' . str_pad($columnName, $columnWidth) . ' |';
        }
        echo PHP_EOL;

        echo '+';
        foreach ($maxColumnWidths as $columnName => $columnWidth) {
            echo '-' . str_pad('', $columnWidth, '-') . '-+';
        }
        echo PHP_EOL;

        foreach ($devices as $device) {
            echo '|';
            foreach ($maxColumnWidths as $columnName => $columnWidth) {
                if ($columnName === 'name') {
                    echo ' ' . str_pad($device->name(), $columnWidth) . ' |';
                } else {
                    $found = false;
                    foreach ($device->attributes() as $attribute) {
                        if ($attribute->type()->name() == $columnName) {
                            echo ' ' . str_pad($attribute->value(), $columnWidth) . ' |';
                            $found = true;
                        }
                    }
                    if ($found === false) {
                        echo ' ' . str_pad('', $columnWidth) . ' |';
                    }


                }
            }
            echo PHP_EOL;
        }
    }
}
