<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use DateTime;

/**
 * Timestampable trait
 *
 * 作成日時、更新日時に関する機能。
 */
trait TimestampableTrait
{
    /** @ORM\Column(type="datetime", name="created_at") */
    protected DateTime $createdAt;

    /** @ORM\Column(type="datetime", name="updated_at") */
    protected DateTime $updatedAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|string $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt instanceof DateTime
            ? $createdAt
            : new DateTime($createdAt);
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|string $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt instanceof DateTime
            ? $updatedAt
            : new DateTime($updatedAt);
    }

    /**
     * @ORM\PrePersist
     */
    public function persistTimestamp(): void
    {
        $this->setCreatedAt('now');
        $this->setUpdatedAt('now');
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateTimestamp(): void
    {
        $this->setUpdatedAt('now');
    }
}
