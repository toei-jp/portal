<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * TheaterMeta entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="theater_meta", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class TheaterMeta extends AbstractEntity
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="Theater")
     * @ORM\JoinColumn(name="theater_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected Theater $theater;

    /**
     * @ORM\Column(type="json", name="opening_hours")
     *
     * @var array{type:int,from_date:string,to_date:string|null,time:string}[]
     */
    protected array $openingHours;

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

    /**
     * @return TheaterOpeningHour[]
     */
    public function getOpeningHours(): array
    {
        $hours = [];

        if (is_array($this->openingHours)) {
            foreach ($this->openingHours as $hour) {
                $hours[] = TheaterOpeningHour::create($hour);
            }
        }

        return $hours;
    }

    /**
     * @param TheaterOpeningHour[] $openingHours
     *
     * @throws LogicException
     */
    public function setOpeningHours(array $openingHours): void
    {
        throw new LogicException('Not allowed.');
    }
}
