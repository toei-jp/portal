<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * AdminUser entity class
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="admin_user", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class AdminUser extends AbstractEntity
{
    use SoftDeleteTrait;
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="display_name")
     *
     * @var string
     */
    protected $displayName;

    /**
     * @ORM\Column(type="string", length=60, options={"fixed":true})
     *
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="smallint", name="`group`", options={"unsigned"=true})
     *
     * @var int
     */
    protected $group;

    /**
     * @ORM\ManyToOne(targetEntity="Theater", inversedBy="adminUsers")
     * @ORM\JoinColumn(name="theater_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     *
     * @var Theater|null
     */
    protected $theater;

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

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws LogicException
     */
    public function setName(string $name): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @throws LogicException
     */
    public function setDisplayName(string $displayName): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @throws LogicException
     */
    public function setPassword(string $password): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getGroup(): int
    {
        return $this->group;
    }

    /**
     * @throws LogicException
     */
    public function setGroup(int $group): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getTheater(): ?Theater
    {
        return $this->theater;
    }

    /**
     * @throws LogicException
     */
    public function setTheater(?Theater $theater): void
    {
        throw new LogicException('Not allowed.');
    }
}
