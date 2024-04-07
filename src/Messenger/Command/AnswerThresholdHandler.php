<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Repository\AnswerRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class AnswerThresholdHandler
{
    public function __construct(
        private AnswerRepository $answerRepo,
    ) {
    }

    public function __invoke(AnswerThreshold $command): void
    {
        $answer = $this->answerRepo->get($command->answerId);
        $answer->setThreshold($command->getThreshold());
        $answer->setGuessedEmotion($command->getGuessedEmotion());
        $this->answerRepo->flush();
    }
}
