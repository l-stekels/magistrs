<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\Timestamped;
use App\Enum\Education;
use App\Enum\Emotion;
use App\Enum\Gender;
use App\Enum\Hobby;
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

    #[ORM\Column(nullable: true, enumType: Gender::class)]
    private ?Gender $gender = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[Column(nullable: true)]
    private ?\DateTimeImmutable $completedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $threshold = null;

    #[ORM\Column(nullable: true, enumType: WalkerEmotion::class)]
    private ?WalkerEmotion $walkerEmotion = null;

    #[ORM\Column(nullable: true)]
    private ?string $customEmotion = null;

    #[ORM\Column(nullable: true, enumType: WalkerEmotion::class)]
    private ?WalkerEmotion $guessedEmotion = null;

    #[ORM\Column(type: 'json', enumType: Hobby::class, options: ['default' => '[]'])]
    private array $hobbies = [];

    #[ORM\Column(nullable: true, enumType: Education::class)]
    private ?Education $education = null;

    #[ORM\Column(type: 'json', options: ['default' => '[]'])]
    private array $gewEmotions = [];

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', nullable: false)]
        private Uuid $id,
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

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function getAge(): ?int
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

    /**
     * @return Hobby[]
     */
    public function getHobbies(): array
    {
        return $this->hobbies;
    }

    public function getStringHobbies(): string
    {
        return implode(
            ', ',
            array_map(static fn(Hobby $hobby) => $hobby->value, $this->hobbies)
        );
    }

    /**
     * @param Hobby[] $hobbies
     */
    public function setHobbies(array $hobbies): void
    {
        $this->hobbies = $hobbies;
    }

    public function getEducation(): ?Education
    {
        return $this->education;
    }

    public function setEducation(Education $education): void
    {
        $this->education = $education;
    }

    public function getGewEmotions(): array
    {
        return $this->gewEmotions;
    }

    public function setGewEmotions(array $gewEmotions): void
    {
        $this->gewEmotions = $gewEmotions;
    }

    public function addGewEmotion(Emotion $emotion, int $intensity): void
    {
        $this->gewEmotions[] = [
            'emotion' => $emotion,
            'intensity' => $intensity,
        ];
    }

    public function getTest(): Test
    {
        return $this->test;
    }
}
