<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\Timestamped;
use App\Enum\Emotion;
use App\Enum\Gender;
use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping\Column;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Answer
{
    use Timestamped;

    #[ORM\Column(enumType: Gender::class)]
    private ?Gender $gender = null;

    #[ORM\Column]
    private ?int $age = null;

    #[Column(nullable: true)]
    private ?\DateTimeImmutable $completedAt = null;

    #[ORM\Column]
    private ?int $threshold = null;

    #[ORM\Column]
    private ?Emotion $wheelEmotion = null;

    #[ORM\Column]
    private ?int $wheelScore = null;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', nullable: false)]
        private readonly Uuid $id,
        #[ORM\ManyToOne(targetEntity: Test::class, inversedBy: 'answers')]
        #[ORM\JoinColumn(nullable: false)]
        private readonly Test $test,
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

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTimeImmutable $completedAt): void
    {
        $this->completedAt = $completedAt;
    }

    public function getThreshold(): ?int
    {
        return $this->threshold;
    }

    public function setThreshold(?int $threshold): void
    {
        $this->threshold = $threshold;
    }

    public function getWheelEmotion(): ?Emotion
    {
        return $this->wheelEmotion;
    }

    public function setWheelEmotion(Emotion $wheelEmotion): void
    {
        $this->wheelEmotion = $wheelEmotion;
    }

    public function getWheelScore(): ?int
    {
        return $this->wheelScore;
    }

    public function setWheelScore(int $wheelScore): void
    {
        $this->wheelScore = $wheelScore;
    }
}
