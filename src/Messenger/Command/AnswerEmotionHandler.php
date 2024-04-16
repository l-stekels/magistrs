<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Enum\WalkerEmotion;
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
        foreach ($command->getEmotions() as $emotion) {
            $answer->addGewEmotion($emotion['emotion'], $emotion['intensity']);
        }
        $answer->setCustomEmotion($command->getCustomEmotion());
        // Set the walker emotion for the next step of the test
        $answer->setWalkerEmotion(WalkerEmotion::random());
        $this->answerRepo->flush();
    }
}
