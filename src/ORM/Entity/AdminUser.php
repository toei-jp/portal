<?php

/**
 * AdminUser.php
 */

namespace Toei\Portal\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * id
     *
     * @ORM\Id
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     * @ORM\GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * name
     *
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    protected $name;

    /**
     * display_name
     *
     * @ORM\Column(type="string", name="display_name")
     *
     * @var string
     */
    protected $displayName;

    /**
     * password
     *
     * @ORM\Column(type="string", length=60, options={"fixed":true})
     *
     * @var string
     */
    protected $password;

    /**
     * group
     *
     * @ORM\Column(type="smallint", name="`group`", options={"unsigned"=true})
     *
     * @var int
     */
    protected $group;

    /**
     * theater
     *
     * @ORM\ManyToOne(targetEntity="Theater", inversedBy="adminUsers")
     * @ORM\JoinColumn(name="theater_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     *
     * @var Theater|null
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
     * get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set name
     *
     * @param string $name
     * @return void
     *
     * @throws \LogicException
     */
    public function setName(string $name)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get display_name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * set display_name
     *
     * @param string $displayName
     * @return void
     *
     * @throws \LogicException
     */
    public function setDisplayName(string $displayName)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * set password
     *
     * @param string $password
     * @return void
     *
     * @throws \LogicException
     */
    public function setPassword(string $password)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get group
     *
     * @return int
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * set group
     *
     * @param int $group
     * @return void
     *
     * @throws \LogicException
     */
    public function setGroup(int $group)
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
