<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template T of object
 *
 * @extends ServiceEntityRepository<T>
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * @param T $entity
     */
    final public function save(object $entity): void
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * @param T $entity
     */
    public function persist(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * @param T $entity
     */
    public function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param T $entity
     */
    public function refresh(object $entity): void
    {
        $this->getEntityManager()->refresh($entity);
    }
}
