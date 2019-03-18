<?php
/**
 * AdvanceTicketExtension.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Twig\Extension;

use Toei\Portal\ORM\Entity\AdvanceTicket;

/**
 * AdvanceTicket twig extension class
 */
class AdvanceTicketExtension extends \Twig_Extension
{
    /**
     * construct
     */
    public function __construct()
    {
    }
    
    /**
     * get functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('at_type_label', [$this, 'getTypeLabel']),
            new \Twig_Function('at_special_gift_stock_label', [$this, 'getSpecialGiftStockLabel']),
        ];
    }
    
    /**
     * return type label
     *
     * @param int $type
     * @return string|null
     */
    public function getTypeLabel(int $type)
    {
        if ($type === AdvanceTicket::TYPE_MVTK) {
            return 'ムビチケ';
        } elseif ($type === AdvanceTicket::TYPE_PAPER) {
            return '紙券';
        }
        
        throw null;
    }
    
    /**
     * return special gift stock label
     *
     * @param int|null $specialGiftStock
     * @return string
     */
    public function getSpecialGiftStockLabel(?int $specialGiftStock)
    {
        if ($specialGiftStock === AdvanceTicket::SPECIAL_GIFT_STOCK_IN) {
            return '（有り）';
        } elseif ($specialGiftStock === AdvanceTicket::SPECIAL_GIFT_STOCK_FEW) {
            return '（残り僅か）';
        } elseif ($specialGiftStock === AdvanceTicket::SPECIAL_GIFT_STOCK_NOT_IN) {
            return '（特典終了）';
        }
        
        return '';
    }
}
