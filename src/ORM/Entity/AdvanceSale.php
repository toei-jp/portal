<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * AdvanceSale entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="advance_sale", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class AdvanceSale extends AbstractEntity
{
    use SavedUserTrait;
    use SoftDeleteTrait;
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Theater")
     * @ORM\JoinColumn(name="theater_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected Theater $theater;

    /**
     * @ORM\ManyToOne(targetEntity="Title")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected Title $title;

    /** @ORM\Column(type="date", name="publishing_expected_date", nullable=true) */
    protected ?DateTime $publishingExpectedDate = null;

    /** @ORM\Column(type="string", name="publishing_expected_date_text", nullable=true) */
    protected ?string $publishingExpectedDateText = null;

    /**
     * @ORM\OneToMany(targetEntity="AdvanceTicket", mappedBy="advanceSale", indexBy="id")
     *
     * @var Collection<AdvanceTicket>
     */
    protected Collection $advanceTickets;

    /**
     * @throws LogicException
     */
    public function __construct()
    {
        throw new LogicException('Not allowed.');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTheater(): Theater
    {
        return $this->theater;
    }

    /**
     * @throws LogicException
     */
    public function setTheater(Theater $theater): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @throws LogicException
     */
    public function setTitle(Title $title): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getPublishingExpectedDate(): ?DateTime
    {
        return $this->publishingExpectedDate;
    }

    /**
     * @param DateTime|string|null $publishingExpectedDate
     *
     * @throws LogicException
     */
    public function setPublishingExpectedDate($publishingExpectedDate): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getPublishingExpectedDateText(): ?string
    {
        return $this->publishingExpectedDateText;
    }

    /**
     * @throws LogicException
     */
    public function setPublishingExpectedDateText(?string $publishingExpectedDateText): void
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * @return Collection<int, AdvanceTicket>
     */
    public function getAdvanceTickets(): Collection
    {
        return $this->advanceTickets;
    }
}
