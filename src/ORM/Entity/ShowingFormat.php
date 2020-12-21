<?php

namespace Toei\Portal\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShowingFormat entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="showing_format", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class ShowingFormat extends AbstractEntity
{
    use TimestampableTrait;

    public const SYSTEM_2D       = 1;
    public const SYSTEM_3D       = 2;
    public const SYSTEM_4DX      = 3;
    public const SYSTEM_4DX3D    = 4;
    public const SYSTEM_IMAX     = 5;
    public const SYSTEM_IMAX3D   = 6;
    public const SYSTEM_BESTIA   = 7;
    public const SYSTEM_BESTIA3D = 8;
    public const SYSTEM_BTSX     = 9;
    public const SYSTEM_SCREENX  = 10; // SASAKI-351
    public const SYSTEM_NONE     = 99;

    public const VOICE_SUBTITLE = 1;
    public const VOICE_DUB      = 2;
    public const VOICE_NONE     = 3;

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
     * system
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     *
     * @var int
     */
    protected $system;

    /**
     * voice
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     *
     * @var int
     */
    protected $voice;

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
     * schedule
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
     * get system
     *
     * @return int
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * set system
     *
     * @param int $system
     * @return void
     *
     * @throws \LogicException
     */
    public function setSystem(int $system)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get voice
     *
     * @return int
     */
    public function getVoice()
    {
        return $this->voice;
    }

    /**
     * set voice
     *
     * @param int $voice
     * @return void
     *
     * @throws \LogicException
     */
    public function setVoice(int $voice)
    {
        throw new \LogicException('Not allowed.');
    }
}
