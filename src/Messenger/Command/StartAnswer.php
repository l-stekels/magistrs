<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Enum\Education;
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

    private Education $education;

    private array $hobbies;

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

    public function getEducation(): Education
    {
        return $this->education;
    }

    public function setEducation(Education $education): void
    {
        $this->education = $education;
    }

    public function getHobbies(): array
    {
        return $this->hobbies;
    }

    public function setHobbies(array $hobbies): void
    {
        $this->hobbies = $hobbies;
    }

    public function addHobby(): void
    {

    }
}
