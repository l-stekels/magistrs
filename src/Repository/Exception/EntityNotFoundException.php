<?php

declare(strict_types=1);

namespace App\Repository\Exception;

use Symfony\Component\Messenger\Exception\UnrecoverableExceptionInterface;
use Symfony\Component\Uid\Uuid;

class EntityNotFoundException extends \Exception implements UnrecoverableExceptionInterface
{
    public static function create(string $entityName, Uuid $entityId): self
    {
        return new self(sprintf('"%s" with id "%s" could not be found.', $entityName, $entityId->toRfc4122()));
    }

    /**
     * @param class-string $entityName
     * @param array<string, string> $criteria
     */
    public static function createForCriteria(string $entityName, array $criteria): self
    {
        return new self(
            sprintf('"%s" with criteria "%s" could not be found.', $entityName, print_r($criteria, true))
        );
    }
}
