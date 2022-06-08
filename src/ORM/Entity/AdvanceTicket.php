<?php

declare(strict_types=1);

namespace App\ORM\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * AdvanceTicket entity class
 *
 * @ORM\Entity(readOnly=true, repositoryClass="App\ORM\Repository\AdvanceTicketRepository")
 * @ORM\Table(name="advance_ticket", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class AdvanceTicket extends AbstractEntity
{
    use SoftDeleteTrait;
    use TimestampableTrait;

    public const TYPE_MVTK  = 1;
    public const TYPE_PAPER = 2;

    public const SPECIAL_GIFT_STOCK_IN     = 1;
    public const SPECIAL_GIFT_STOCK_FEW    = 2;
    public const SPECIAL_GIFT_STOCK_NOT_IN = 3;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="AdvanceSale")
     * @ORM\JoinColumn(name="advance_sale_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected AdvanceSale $advanceSale;

    /** @ORM\Column(type="datetime", name="release_dt") */
    protected DateTime $releaseDt;

    /** @ORM\Column(type="string", name="release_dt_text", nullable=true) */
    protected ?string $releaseDtText = null;

    /** @ORM\Column(type="boolean", name="is_sales_end", options={"default":false}) */
    protected bool $isSalesEnd;

    /** @ORM\Column(type="smallint", options={"unsigned"=true}) */
    protected int $type;

    /** @ORM\Column(type="string", name="price_text", nullable=true) */
    protected ?string $priceText = null;

    /** @ORM\Column(type="string", name="special_gift", nullable=true) */
    protected ?string $specialGift = null;

    /** @ORM\Column(type="smallint", name="special_gift_stock", nullable=true, options={"unsigned"=true}) */
    protected ?int $specialGiftStock = null;

    /**
     * @ORM\OneToOne(targetEntity="File")
     * @ORM\JoinColumn(name="special_gift_image", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     */
    protected ?File $specialGiftImage = null;

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

    public function getAdvanceSale(): AdvanceSale
    {
        return $this->advanceSale;
    }

    /**
     * @throws LogicException
     */
    public function setAdvanceSale(AdvanceSale $advanceSale): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getReleaseDt(): DateTime
    {
        return $this->releaseDt;
    }

    /**
     * @param DateTime|string $releaseDt
     *
     * @throws LogicException
     */
    public function setReleaseDt($releaseDt): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getReleaseDtText(): ?string
    {
        return $this->releaseDtText;
    }

    /**
     * @throws LogicException
     */
    public function setReleaseDtText(?string $releaseDtText): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getIsSalesEnd(): bool
    {
        return $this->isSalesEnd;
    }

    /**
     * alias getIsSalesEnd()
     */
    public function isSalseEnd(): bool
    {
        return $this->getIsSalesEnd();
    }

    /**
     * @throws LogicException
     */
    public function setIsSalesEnd(bool $isSalesEnd): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @throws LogicException
     */
    public function setType(int $type): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getPriceText(): ?string
    {
        return $this->priceText;
    }

    /**
     * @throws LogicException
     */
    public function setPriceText(?string $priceText): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getSpecialGift(): ?string
    {
        return $this->specialGift;
    }

    /**
     * @throws LogicException
     */
    public function setSpecialGift(?string $specialGift): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getSpecialGiftStock(): ?int
    {
        return $this->specialGiftStock;
    }

    public function isSpecialGiftStock(int $stock): bool
    {
        return $this->getSpecialGiftStock() === $stock;
    }

    /**
     * 特典あり
     */
    public function isSpecialGiftStockIn(): bool
    {
        return $this->isSpecialGiftStock(self::SPECIAL_GIFT_STOCK_IN);
    }

    /**
     * 特典残り僅か
     */
    public function isSpecialGiftStockFew(): bool
    {
        return $this->isSpecialGiftStock(self::SPECIAL_GIFT_STOCK_FEW);
    }

    /**
     * 特典終了
     */
    public function isSpecialGiftStockNotIn(): bool
    {
        return $this->isSpecialGiftStock(self::SPECIAL_GIFT_STOCK_NOT_IN);
    }

    /**
     * @throws LogicException
     */
    public function setSpecialGiftStock(?int $specialGiftStock): void
    {
        throw new LogicException('Not allowed.');
    }

    public function getSpecialGiftImage(): ?File
    {
        return $this->specialGiftImage;
    }

    /**
     * @throws LogicException
     */
    public function setSpecialGiftImage(?File $specialGiftImage): void
    {
        throw new LogicException('Not allowed.');
    }
}
