<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private string $title;
    private bool $isEyeTracking = false;
    private bool $isShared = false;

    public function __construct(
        public readonly Uuid $id,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function isEyeTracking(): bool
    {
        return $this->isEyeTracking;
    }

    public function setIsEyeTracking(bool $isEyeTracking): void
    {
        $this->isEyeTracking = $isEyeTracking;
    }

    public function isShared(): bool
    {
        return $this->isShared;
    }

    public function setIsShared(bool $isShared): void
    {
        $this->isShared = $isShared;
    }
}
