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

    public function getActiveTest(): Test
    {
        $test = $this->findOneBy(['active' => true]);
        if (null === $test) {
            throw EntityNotFoundException::createForCriteria(Test::class, ['active' => true]);
        }

        return $test;
    }
}
