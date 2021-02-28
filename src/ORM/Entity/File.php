<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * File entity class
 *
 * @todo 削除のイベントでファイルも削除される仕組み
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="file", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class File extends AbstractEntity
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
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="original_name")
     *
     * @var string
     */
    protected $originalName;

    /**
     * @ORM\Column(type="string", name="mime_type")
     *
     * @var string
     */
    protected $mimeType;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $size;

    /**
     * blob container name
     *
     * @var string
     */
    protected static $blobContainer = 'file';

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

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @throws LogicException
     */
    public function setOriginalName(string $originalName): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @throws LogicException
     */
    public function setMimeType(string $mimeType): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @throws LogicException
     */
    public function setSize(int $size): void
    {
        throw new LogicException('Not allowed.');
    }

    public static function getBlobContainer(): string
    {
        return self::$blobContainer;
    }
}
