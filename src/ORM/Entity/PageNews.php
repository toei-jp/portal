<?php

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageNews entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="page_news", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class PageNews extends AbstractEntity
{
    use TimestampableTrait;

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
     * news
     *
     * @ORM\ManyToOne(targetEntity="News", inversedBy="pages")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var News
     */
    protected $news;

    /**
     * page
     *
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="newsList")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Page
     */
    protected $page;

    /**
     * display_order
     *
     * @ORM\Column(type="smallint", name="display_order", options={"unsigned"=true})
     *
     * @var int
     */
    protected $displayOrder;

    /**
     * construct
     *
     * @throws \LogicException
     */
    public function __construct()
    {
        throw new \LogicException('Not allowed.');
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
     * get news
     *
     * @return News
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * set news
     *
     * @param News $news
     * @return void
     *
     * @throws \LogicException
     */
    public function setNews(News $news)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * page
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * set page
     *
     * @param Page $page
     * @return void
     *
     * @throws \LogicException
     */
    public function setPage(Page $page)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get display_order
     *
     * @return int
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * set display_order
     *
     * @param int $displayOrder
     * @return void
     *
     * @throws \LogicException
     */
    public function setDisplayOrder(int $displayOrder)
    {
        throw new \LogicException('Not allowed.');
    }
}
