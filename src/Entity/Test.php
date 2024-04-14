<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\Timestamped;
use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TestRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Test
{
    use Timestamped;

    /**
     * @var Collection<int, Answer> $items
     */
    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: 'test', orphanRemoval: true)]
    #[ORM\OrderBy(['createdAt' => 'ASC'])]
    private Collection $answers;

    #[ORM\Column(nullable: false)]
    private bool $isEyeTracking;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid')]
        private readonly Uuid $id,
        #[ORM\Column(unique: true)]
        private string $shortIdentifier,
        #[ORM\Column]
        private string $title,
    ) {
        $this->answers = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $item): void
    {
        if (!$this->answers->contains($item)) {
            $this->answers->add($item);
        }
    }

    public function getShortIdentifier(): string
    {
        return $this->shortIdentifier;
    }

    public function setShortIdentifier(string $shortIdentifier): void
    {
        $this->shortIdentifier = $shortIdentifier;
    }

    public function isEyeTracking(): bool
    {
        return $this->isEyeTracking;
    }

    public function setEyeTracking(bool $isEyeTracking): void
    {
        $this->isEyeTracking = $isEyeTracking;
    }
}
