<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * TheaterMainBanner entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="theater_main_banner", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class TheaterMainBanner extends AbstractEntity
{
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
     * @ORM\ManyToOne(targetEntity="MainBanner")
     * @ORM\JoinColumn(name="main_banner_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var MainBanner
     */
    protected $mainBanner;

    /**
     * @ORM\ManyToOne(targetEntity="Theater", inversedBy="theaters")
     * @ORM\JoinColumn(name="theater_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Theater
     */
    protected $theater;

    /**
     * @ORM\Column(type="smallint", name="display_order", options={"unsigned"=true})
     *
     * @var int
     */
    protected $displayOrder;

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

    public function getMainBanner(): MainBanner
    {
        return $this->mainBanner;
    }

    /**
     * @throws LogicException
     */
    public function setMainBanner(MainBanner $mainBanner): void
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
