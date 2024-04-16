<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
use App\Repository\TestRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class SaveDemographicHandler
{
    public function __construct(
        private AnswerRepository $answerRepository,
    ) {
    }

    public function __invoke(SaveDemographic $command): void
    {
        $answer = $this->answerRepository->find($command->answerId);
        if (!$answer instanceof Answer) {
            throw new \RuntimeException('Answer not found');
        }
        $answer->setAge($command->getAge());
        $answer->setGender($command->getGender());
        $answer->setHobbies($command->getHobbies());
        $answer->setEducation($command->getEducation());
        $this->answerRepository->flush();
    }
}
