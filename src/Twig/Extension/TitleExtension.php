<?php

namespace App\Twig\Extension;

use App\ORM\Entity\Title;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Title twig extension class
 */
class TitleExtension extends AbstractExtension
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
            new TwigFunction('title_rating_text', [$this, 'getRatingText']),
        ];
    }

    /**
     * return rating text
     *
     * @param int $rating
     * @return string
     */
    public function getRatingText(int $rating)
    {
        switch ($rating) {
            case Title::RATING_G:
                return 'G';

            case Title::RATING_PG12:
                return 'PG12';

            case Title::RATING_R15:
                return 'R15+';

            case Title::RATING_R18:
                return 'R18+';

            default:
                return '';
        }
    }
}
