<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\Uuid;

/**
 * @template T
 *
 * @extends ServiceEntityRepository<T>
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * @return T
     * @throws EntityNotFoundException
     */
    public function get(Uuid $id)
    {
        $entity = $this->find($id);
        if (null ===$entity) {
            throw EntityNotFoundException::create($this->getEntityName(), $id);
        }

        return $entity;
    }

    /**
     * @param object<T> $entity
     */
    final public function save(object $entity): void
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * @param object<T> $entity
     */
    public function persist(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * @param object<T> $entity
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
     * @param object<T> $entity
     * @throws ORMException
     */
    public function refresh(object $entity): void
    {
        $this->getEntityManager()->refresh($entity);
    }
}
