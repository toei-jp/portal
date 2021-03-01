<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\ORM\Entity\AdvanceTicket;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AdvanceTicketExtension extends AbstractExtension
{
    public function __construct()
    {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('at_type_label', [$this, 'getTypeLabel']),
            new TwigFunction('at_special_gift_stock_label', [$this, 'getSpecialGiftStockLabel']),
        ];
    }

    public function getTypeLabel(int $type): string
    {
        switch ($type) {
            case AdvanceTicket::TYPE_MVTK:
                return 'ムビチケ';

            case AdvanceTicket::TYPE_PAPER:
                return '紙券';

            default:
                return '';
        }
    }

    public function getSpecialGiftStockLabel(?int $specialGiftStock): string
    {
        switch ($specialGiftStock) {
            case AdvanceTicket::SPECIAL_GIFT_STOCK_IN:
                return '（有り）';

            case AdvanceTicket::SPECIAL_GIFT_STOCK_FEW:
                return '（残り僅か）';

            case AdvanceTicket::SPECIAL_GIFT_STOCK_NOT_IN:
                return '（特典終了）';

            default:
                return '';
        }
    }
}
