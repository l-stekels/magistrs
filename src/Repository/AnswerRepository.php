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
}
