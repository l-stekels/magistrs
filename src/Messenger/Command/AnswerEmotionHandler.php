<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Entity\Answer;
use App\Enum\WalkerEmotion;
use App\Repository\AnswerRepository;
use App\Repository\TestRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class AnswerEmotionHandler
{
    public function __construct(
        private AnswerRepository $answerRepo,
        private TestRepository $testRepo,
    ) {
    }

    public function __invoke(AnswerEmotion $command): void
    {
        $test = $this->testRepo->find($command->testId);
        $answer = new Answer(
            $command->answerId,
            $test,
            $command->isMobile,
        );
        foreach ($command->getEmotions() as $emotion) {
            $answer->addGewEmotion($emotion['emotion'], $emotion['intensity']);
        }
        $answer->setCustomEmotion($command->getCustomEmotion());
        // Set the walker emotion for the next step of the test
        $answer->setWalkerEmotion(WalkerEmotion::random());
        $this->answerRepo->save($answer);
    }
}
