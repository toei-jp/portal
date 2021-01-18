<?php

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShowingTheater entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="showing_theater", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class ShowingTheater extends AbstractEntity
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
     * schedule
     *
     * @ORM\ManyToOne(targetEntity="Schedule")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Schedule
     */
    protected $schedule;

    /**
     * theater
     *
     * @ORM\ManyToOne(targetEntity="Theater")
     * @ORM\JoinColumn(name="theater_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var Theater
     */
    protected $theater;

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
     * get schedule
     *
     * @return Schedule
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * set schedule
     *
     * @param Schedule $schedule
     * @return void
     *
     * @throws \LogicException
     */
    public function setSchedule(Schedule $schedule)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get theater
     *
     * @return Theater
     */
    public function getTheater()
    {
        return $this->theater;
    }

    /**
     * set theater
     *
     * @param Theater $theater
     * @return void
     *
     * @throws \LogicException
     */
    public function setTheater(Theater $theater)
    {
        throw new \LogicException('Not allowed.');
    }
}
