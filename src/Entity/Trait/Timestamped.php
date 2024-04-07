<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

/**
 * Don't forget to add #[ORM\HasLifecycleCallbacks] to the target entity.
 */
trait Timestamped
{
    #[Column]
    private \DateTimeImmutable $createdAt;

    #[Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[PreUpdate]
    public function onUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
