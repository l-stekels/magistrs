<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
use App\Repository\TestRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class StartAnswerHandler
{
    public function __construct(
        private TestRepository $testRepository,
        private AnswerRepository $answerRepository,
    ) {
    }

    public function __invoke(StartAnswer $command): void
    {
        $test = $this->testRepository->find($command->testId);
        $answer = new Answer(
            $command->id,
            $test,
            $command->isMobile,
        );
        $answer->setAge($command->getAge());
        $answer->setGender($command->getGender());
        $answer->setHobbies($command->getHobbies());
        $answer->setEducation($command->getEducation());
        $this->answerRepository->save($answer);
    }
}
