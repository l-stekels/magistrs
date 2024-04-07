<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\Timestamped;
use App\Enum\Emotion;
use App\Enum\Gender;
use App\Enum\WalkerEmotion;
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

    #[ORM\Column(nullable: true)]
    private ?int $threshold = null;

    #[ORM\Column(nullable: true, enumType: Emotion::class)]
    private ?Emotion $wheelEmotion = null;

    #[ORM\Column(nullable: true)]
    private ?int $wheelScore = null;

    #[ORM\Column(nullable: true, enumType: WalkerEmotion::class)]
    private ?WalkerEmotion $walkerEmotion = null;

    #[ORM\Column(nullable: true)]
    private ?string $customEmotion = null;

    #[ORM\Column(nullable: true, enumType: WalkerEmotion::class)]
    private ?WalkerEmotion $guessedEmotion = null;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', nullable: false)]
        private readonly Uuid $id,
        #[ORM\ManyToOne(targetEntity: Test::class, inversedBy: 'answers')]
        #[ORM\JoinColumn(nullable: false)]
        private readonly Test $test,
        #[ORM\Column]
        private readonly bool $isMobile,
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
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

    public function getIsMobile(): bool
    {
        return $this->isMobile;
    }

    public function getWalkerEmotion(): ?WalkerEmotion
    {
        return $this->walkerEmotion;
    }

    public function setWalkerEmotion(?WalkerEmotion $walkerEmotion): void
    {
        $this->walkerEmotion = $walkerEmotion;
    }

    public function getCustomEmotion(): ?string
    {
        return $this->customEmotion;
    }

    public function setCustomEmotion(?string $customEmotion): void
    {
        $this->customEmotion = $customEmotion;
    }

    public function getGuessedEmotion(): ?WalkerEmotion
    {
        return $this->guessedEmotion;
    }

    public function setGuessedEmotion(WalkerEmotion $emotion):void
    {
        $this->guessedEmotion = $emotion;
    }
}
