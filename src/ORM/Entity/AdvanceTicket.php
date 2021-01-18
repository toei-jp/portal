<?php

namespace App\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * advance_sale
     *
     * @ORM\ManyToOne(targetEntity="AdvanceSale")
     * @ORM\JoinColumn(name="advance_sale_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     *
     * @var AdvanceSale
     */
    protected $advanceSale;

    /**
     * release_dt
     *
     * @ORM\Column(type="datetime", name="release_dt")
     *
     * @var \DateTime
     */
    protected $releaseDt;

    /**
     * release_dt_text
     *
     * @ORM\Column(type="string", name="release_dt_text", nullable=true)
     *
     * @var string|null
     */
    protected $releaseDtText;

    /**
     * is_sales_end
     *
     * @ORM\Column(type="boolean", name="is_sales_end", options={"default":false})
     *
     * @var bool
     */
    protected $isSalesEnd;

    /**
     * type
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     *
     * @var int
     */
    protected $type;

    /**
     * price_text
     *
     * @ORM\Column(type="string", name="price_text", nullable=true)
     *
     * @var string|null
     */
    protected $priceText;

    /**
     * special_gift
     *
     * @ORM\Column(type="string", name="special_gift", nullable=true)
     *
     * @var string|null
     */
    protected $specialGift;

    /**
     * special_gift_stock
     *
     * @ORM\Column(type="smallint", name="special_gift_stock", nullable=true, options={"unsigned"=true})
     *
     * @var int|null
     */
    protected $specialGiftStock;

    /**
     * special_gift_image
     *
     * @ORM\OneToOne(targetEntity="File")
     * @ORM\JoinColumn(name="special_gift_image", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     *
     * @var File|null
     */
    protected $specialGiftImage;

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
     * get advance_sale
     *
     * @return AdvanceSale
     */
    public function getAdvanceSale()
    {
        return $this->advanceSale;
    }

    /**
     * set advance_sale
     *
     * @param AdvanceSale $advanceSale
     * @return void
     *
     * @throws \LogicException
     */
    public function setAdvanceSale(AdvanceSale $advanceSale)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get release_dt
     *
     * @return \DateTime
     */
    public function getReleaseDt()
    {
        return $this->releaseDt;
    }

    /**
     * set release_dt
     *
     * @param \DateTime|string $releaseDt
     * @return void
     *
     * @throws \LogicException
     */
    public function setReleaseDt($releaseDt)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get release_dt_text
     *
     * @return string|null
     */
    public function getReleaseDtText()
    {
        return $this->releaseDtText;
    }

    /**
     * set release_dt_text
     *
     * @param string|null $releaseDtText
     * @return void
     *
     * @throws \LogicException
     */
    public function setReleaseDtText(?string $releaseDtText)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get is_sales_end
     *
     * @return bool
     */
    public function getIsSalesEnd()
    {
        return $this->isSalesEnd;
    }

    /**
     * is salse end
     *
     * alias getIsSalesEnd()
     *
     * @return bool
     */
    public function isSalseEnd()
    {
        return $this->getIsSalesEnd();
    }

    /**
     * set is_salse_end
     *
     * @param bool $isSalesEnd
     * @return void
     *
     * @throws \LogicException
     */
    public function setIsSalesEnd(bool $isSalesEnd)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * set type
     *
     * @param int $type
     * @return void
     *
     * @throws \LogicException
     */
    public function setType(int $type)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get price_text
     *
     * @return string|null
     */
    public function getPriceText()
    {
        return $this->priceText;
    }

    /**
     * set price_text
     *
     * @param string|null $priceText
     * @return void
     *
     * @throws \LogicException
     */
    public function setPriceText(?string $priceText)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get special_gift
     *
     * @return string|null
     */
    public function getSpecialGift()
    {
        return $this->specialGift;
    }

    /**
     * set special_gift
     *
     * @param string|null $specialGift
     * @return void
     *
     * @throws \LogicException
     */
    public function setSpecialGift(?string $specialGift)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get special_gift_stock
     *
     * @return int|null
     */
    public function getSpecialGiftStock()
    {
        return $this->specialGiftStock;
    }

    /**
     * is special gift stock
     *
     * @param int $stock
     * @return boolean
     */
    public function isSpecialGiftStock(int $stock)
    {
        return $this->getSpecialGiftStock() === $stock;
    }

    /**
     * 特典あり
     *
     * @return boolean
     */
    public function isSpecialGiftStockIn()
    {
        return $this->isSpecialGiftStock(self::SPECIAL_GIFT_STOCK_IN);
    }

    /**
     * 特典残り僅か
     *
     * @return boolean
     */
    public function isSpecialGiftStockFew()
    {
        return $this->isSpecialGiftStock(self::SPECIAL_GIFT_STOCK_FEW);
    }

    /**
     * 特典終了
     *
     * @return boolean
     */
    public function isSpecialGiftStockNotIn()
    {
        return $this->isSpecialGiftStock(self::SPECIAL_GIFT_STOCK_NOT_IN);
    }

    /**
     * set special_gift_stock
     *
     * @param int|null $specialGiftStock
     * @return void
     *
     * @throws \LogicException
     */
    public function setSpecialGiftStock($specialGiftStock)
    {
        throw new \LogicException('Not allowed.');
    }

    /**
     * get special_gift_image
     *
     * @return File|null
     */
    public function getSpecialGiftImage()
    {
        return $this->specialGiftImage;
    }

    /**
     * set special_gift_image
     *
     * @param File|null $specialGiftImage
     * @return void
     *
     * @throws \LogicException
     */
    public function setSpecialGiftImage($specialGiftImage)
    {
        throw new \LogicException('Not allowed.');
    }
}
