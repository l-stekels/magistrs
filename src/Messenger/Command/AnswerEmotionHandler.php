<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Repository\AnswerRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class AnswerEmotionHandler
{
    public function __construct(
        private AnswerRepository $answerRepo,
    ) {
    }

    public function __invoke(AnswerEmotion $command): void
    {
        $answer = $this->answerRepo->get($command->answerId);
        $answer->setWheelEmotion($command->getEmotion());
        $answer->setWheelScore($command->getIntensity());
        $answer->setCompletedAt(new \DateTimeImmutable());
        $answer->setCustomEmotion($command->getCustomEmotion());
        $this->answerRepo->flush();
    }
}
