<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Answer>
 */
class AnswerRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * @return array<int, array{time: int, correct: boolean}>
     */
    public function getStats(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.threshold / 1000 as time', 'CASE WHEN a.guessedEmotion = a.walkerEmotion THEN 1 ELSE 0 END as correct')
            ->getQuery()
            ->getArrayResult();
    }
}
