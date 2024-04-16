<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Enum\Emotion;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class AnswerEmotion
{
    #[Assert\Length(max: 255)]
    private ?string $customEmotion;

    private array $emotions = [];

    public function __construct(
        public readonly Uuid $testId,
        public readonly Uuid $answerId,
        public readonly bool $isMobile,
    ) {
    }

    public function getCustomEmotion(): ?string
    {
        return $this->customEmotion;
    }

    public function setCustomEmotion(?string $customEmotion): void
    {
        $this->customEmotion = $customEmotion;
    }

    /**
     * @return array<array{emotion: string, intensity: int}>
     */
    public function getEmotions(): array
    {
        return $this->emotions;
    }

    public function addEmotion(string $emotion, int $intensity): void
    {
        if (null === Emotion::tryFrom($emotion)) {
            // TODO: Throw an error?
            // Skip invalid values
            return;
        }
        $this->emotions[] = [
            'emotion' => Emotion::from($emotion),
            'intensity' => $intensity,
        ];
    }
}
