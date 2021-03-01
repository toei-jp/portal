<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\ORM\Entity\Title;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TitleExtension extends AbstractExtension
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
            new TwigFunction('title_rating_text', [$this, 'getRatingText']),
        ];
    }

    public function getRatingText(int $rating): string
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
