<?php

namespace App\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

class UuidGenerator extends AbstractIdGenerator
{
    public function generateId(EntityManagerInterface $em, $entity): UuidV4
    {
        if (method_exists($entity, 'getNewId') && $entity->getNewId()) {
            return new UuidV4($entity->getNewId());
        }

        return new UuidV4();
    }

    public function generateIdFromPayload(array $data): Uuid
    {
        if (array_key_exists('newId', $data)) {
            return new Uuid($data['newId']);
        }

        return new UuidV4();
    }
}
