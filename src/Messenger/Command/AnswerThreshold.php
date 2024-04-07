<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Enum\WalkerEmotion;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class AnswerThreshold
{
    #[Assert\Positive]
    #[Assert\Range(min: 1)]
    private int $threshold;

    public function __construct(
        public readonly Uuid $answerId,
        public readonly WalkerEmotion $walkerEmotion,
    ) {
    }

    public function setThreshold(int $threshold): void
    {
        $this->threshold = $threshold;
    }

    public function getThreshold(): int
    {
        return $this->threshold;
    }
}
