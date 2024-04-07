<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Enum\Emotion;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Service\Attribute\Required;

class AnswerEmotion
{
    private ?Emotion $emotion;
    #[Assert\Range(min: 1, max: 5)]
    #[Assert\Positive]
    private ?int $intensity;

    #[Assert\Length(max: 255)]
    private ?string $customEmotion;

    public function __construct(public readonly Uuid $answerId)
    {
    }

    public function getEmotion(): Emotion
    {
        return $this->emotion;
    }

    public function setEmotion(?Emotion $emotion): void
    {
        $this->emotion = $emotion;
    }

    public function getIntensity(): ?int
    {
        return $this->intensity;
    }

    public function setIntensity(?int $intensity): void
    {
        $this->intensity = $intensity;
    }

    public function getCustomEmotion(): ?string
    {
        return $this->customEmotion;
    }

    public function setCustomEmotion(?string $customEmotion): void
    {
        $this->customEmotion = $customEmotion;
    }
}
