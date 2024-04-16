<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Test;
use App\Repository\Exception\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Test>
 */
class TestRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }

    public function getAnyTest(): Test
    {
        $test = $this->findAll()[0];
        if (null === $test) {
            throw EntityNotFoundException::createForCriteria(Test::class, ['active' => true]);
        }

        return $test;
    }

    public function findForUser(bool $isAdmin): array
    {
        $qb = $this->createQueryBuilder('test')
            ->select('test', 'answers')
            ->leftJoin('test.answers', 'answers');
        if (!$isAdmin) {
            $qb->andWhere('test.isShared = true');
        }

        return $qb->getQuery()
            ->getResult();
    }
}
