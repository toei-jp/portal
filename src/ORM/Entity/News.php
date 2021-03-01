<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * News entity class
 *
 * @ORM\Entity(readOnly=true, repositoryClass="App\ORM\Repository\NewsRepository")
 * @ORM\Table(name="news", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class News extends AbstractEntity
{
    use SavedUserTrait;
    use SoftDeleteTrait;
    use TimestampableTrait;

    public const CATEGORY_TOPICS = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Title")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     *
     * @var Title|null
     */
    protected $title;

    /**
     * @ORM\OneToOne(targetEntity="File", fetch="EAGER")
     * @ORM\JoinColumn(name="image_file_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     *
     * @var File
     */
    protected $image;

    /**
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     *
     * @var int
     */
    protected $category;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $headline;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $body;

    /**
     * @ORM\Column(type="datetime", name="start_dt")
     *
     * @var DateTime
     */
    protected $startDt;

    /**
     * @ORM\Column(type="datetime", name="end_dt")
     *
     * @var DateTime
     */
    protected $endDt;

    /**
     * @ORM\OneToMany(targetEntity="PageNews", mappedBy="news")
     *
     * @var Collection<PageNews>
     */
    protected $pages;

    /**
     * @ORM\OneToMany(targetEntity="TheaterNews", mappedBy="news")
     *
     * @var Collection<TheaterNews>
     */
    protected $theaters;

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

    public function getTitle(): ?Title
    {
        return $this->title;
    }

    /**
     * @throws LogicException
     */
    public function setTitle(?Title $title): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getImage(): File
    {
        return $this->image;
    }

    /**
     * @throws LogicException
     */
    public function setImage(File $image): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @throws LogicException
     */
    public function setCategory(int $category): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getHeadline(): string
    {
        return $this->headline;
    }

    /**
     * @throws LogicException
     */
    public function setHeadline(string $headline): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @throws LogicException
     */
    public function setBody(string $body): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getStartDt(): DateTime
    {
        return $this->startDt;
    }

    /**
     * @param DateTime|string $startDt
     *
     * @throws LogicException
     */
    public function setStartDt($startDt): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getEndDt(): DateTime
    {
        return $this->endDt;
    }

    /**
     * @param DateTime|string $endDt
     *
     * @throws LogicException
     */
    public function setEndDt($endDt): void
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * @return Collection<PageNews>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    /**
     * @return Collection<TheaterNews>
     */
    public function getTheaters(): Collection
    {
        return $this->theaters;
    }
}
