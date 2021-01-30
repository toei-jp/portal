<?php

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
     * id
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * title
     *
     * @ORM\ManyToOne(targetEntity="Title")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     *
     * @var Title|null
     */
    protected $title;

    /**
     * image
     *
     * @ORM\OneToOne(targetEntity="File", fetch="EAGER")
     * @ORM\JoinColumn(name="image_file_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     *
     * @var File
     */
    protected $image;

    /**
     * category
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     *
     * @var int
     */
    protected $category;

    /**
     * headline
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $headline;

    /**
     * body
     *
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $body;

    /**
     * start_dt
     *
     * @ORM\Column(type="datetime", name="start_dt")
     *
     * @var DateTime
     */
    protected $startDt;

    /**
     * end_dt
     *
     * @ORM\Column(type="datetime", name="end_dt")
     *
     * @var DateTime
     */
    protected $endDt;

    /**
     * pages
     *
     * @ORM\OneToMany(targetEntity="PageNews", mappedBy="news")
     *
     * @var Collection<PageNews>
     */
    protected $pages;

    /**
     * theaters
     *
     * @ORM\OneToMany(targetEntity="TheaterNews", mappedBy="news")
     *
     * @var Collection<TheaterNews>
     */
    protected $theaters;

    /**
     * construct
     *
     * @throws LogicException
     */
    public function __construct()
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get title
     *
     * @return Title|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * set title
     *
     * @param Title|null $title
     * @return void
     *
     * @throws LogicException
     */
    public function setTitle($title)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get image
     *
     * @return File
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * set image
     *
     * @param File $image
     * @return void
     *
     * @throws LogicException
     */
    public function setImage(File $image)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get category
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * set category
     *
     * @param int $category
     * @return void
     *
     * @throws LogicException
     */
    public function setCategory(int $category)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get headline
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * set headline
     *
     * @param string $headline
     * @return void
     *
     * @throws LogicException
     */
    public function setHeadline(string $headline)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * set body
     *
     * @param string $body
     * @return void
     *
     * @throws LogicException
     */
    public function setBody(string $body)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get start_dt
     *
     * @return DateTime
     */
    public function getStartDt()
    {
        return $this->startDt;
    }

    /**
     * set start_dt
     *
     * @param DateTime|string $startDt
     * @return void
     *
     * @throws LogicException
     */
    public function setStartDt($startDt)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get end_dt
     *
     * @return DateTime
     */
    public function getEndDt()
    {
        return $this->endDt;
    }

    /**
     * set end_dt
     *
     * @param DateTime|string $endDt
     * @return void
     *
     * @throws LogicException
     */
    public function setEndDt($endDt)
    {
        throw new LogicException('Not allowed.');
    }

    /**
     * get pages
     *
     * @return Collection
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    /**
     * get theaters
     *
     * @return Collection
     */
    public function getTheaters(): Collection
    {
        return $this->theaters;
    }
}
