<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * TheaterNews entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="theater_news", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class TheaterNews extends AbstractEntity
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="News")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected News $news;

    /**
     * @ORM\ManyToOne(targetEntity="Theater", inversedBy="theaters")
     * @ORM\JoinColumn(name="theater_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected Theater $theater;

    /** @ORM\Column(type="smallint", name="display_order", options={"unsigned"=true}) */
    protected int $displayOrder;

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

    public function getNews(): News
    {
        return $this->news;
    }

    /**
     * @throws LogicException
     */
    public function setNews(News $news): void
    {
        throw new LogicException('Not allowed.');
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

    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }

    /**
     * @throws LogicException
     */
    public function setDisplayOrder(int $displayOrder): void
    {
        throw new LogicException('Not allowed.');
    }
}
