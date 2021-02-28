<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * Schedule entity class
 *
 * @ORM\Entity(readOnly=true, repositoryClass="App\ORM\Repository\ScheduleRepository")
 * @ORM\Table(name="schedule", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class Schedule extends AbstractEntity
{
    use SavedUserTrait;
    use SoftDeleteTrait;
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Title", fetch="EAGER")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     *
     * @var Title
     */
    protected $title;

    /**
     * @ORM\Column(type="date", name="start_date")
     *
     * @var DateTime
     */
    protected $startDate;

    /**
     * @ORM\Column(type="date", name="end_date")
     *
     * @var DateTime
     */
    protected $endDate;

    /**
     * @ORM\Column(type="datetime", name="public_start_dt")
     *
     * @var DateTime
     */
    protected $publicStartDt;

    /**
     * @ORM\Column(type="datetime", name="public_end_dt")
     *
     * @var DateTime
     */
    protected $publicEndDt;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    protected $remark;

    /**
     * @ORM\OneToMany(targetEntity="ShowingFormat", mappedBy="schedule", orphanRemoval=true, fetch="EAGER")
     *
     * @var Collection<ShowingFormat>
     */
    protected $showingFormats;

    /**
     * @ORM\OneToMany(targetEntity="ShowingTheater", mappedBy="schedule", orphanRemoval=true, fetch="EAGER")
     *
     * @var Collection<ShowingTheater>
     */
    protected $showingTheaters;

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

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime|string $startDate
     *
     * @throws LogicException
     */
    public function setStartDate($startDate): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime|string $endDate
     *
     * @throws LogicException
     */
    public function setEndDate($endDate): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getPublicStartDt(): DateTime
    {
        return $this->publicStartDt;
    }

    /**
     * @param DateTime|string $publicStartDt
     *
     * @throws LogicException
     */
    public function setPublicStartDt($publicStartDt): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getPublicEndDt(): DateTime
    {
        return $this->publicEndDt;
    }

    /**
     * @param DateTime|string $publicEndDt
     *
     * @throws LogicException
     */
    public function setPublicEndDt($publicEndDt): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    /**
     * @throws LogicException
     */
    public function setRemark(?string $remark): void
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * @return Collection<ShowingFormat>
     */
    public function getShowingFormats(): Collection
    {
        return $this->showingFormats;
    }

    /**
     * @param Collection<ShowingFormat> $showingFormats
     *
     * @throws LogicException
     */
    public function setShowingFormats(Collection $showingFormats): void
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * @return Collection<ShowingTheater>
     */
    public function getShowingTheaters(): Collection
    {
        return $this->showingTheaters;
    }

    /**
     * @param Collection<ShowingTheater> $showingTheaters
     *
     * @throws LogicException
     */
    public function setShowingTheaters(Collection $showingTheaters): void
    {
        throw new LogicException('Not allowed.');
    }
}
