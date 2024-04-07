<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Enum\Gender;
use App\Messenger\Middleware\LockableMessageInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class StartAnswer implements LockableMessageInterface
{
    private Gender $gender;

    #[Assert\Positive]
    #[Assert\Range(min: 1, max: 100)]
    private int $age;

    public function __construct(
        public readonly Uuid $id,
        public readonly bool $isMobile,
        public readonly Uuid $testId,
    ) {
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getLockKey(): string
    {
        return 'start_test_'.$this->id->toRfc4122();
    }
}
