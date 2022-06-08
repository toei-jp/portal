<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use LogicException;

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
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Schedule")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected Schedule $schedule;

    /** @ORM\Column(type="smallint", options={"unsigned"=true}) */
    protected int $system;

    /** @ORM\Column(type="smallint", options={"unsigned"=true}) */
    protected int $voice;

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

    public function getSchedule(): Schedule
    {
        return $this->schedule;
    }

    /**
     * @throws LogicException
     */
    public function setSchedule(Schedule $schedule): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getSystem(): int
    {
        return $this->system;
    }

    /**
     * @throws LogicException
     */
    public function setSystem(int $system): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getVoice(): int
    {
        return $this->voice;
    }

    /**
     * @throws LogicException
     */
    public function setVoice(int $voice): void
    {
        throw new LogicException('Not allowed.');
    }
}
