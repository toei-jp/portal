<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\ORM\Entity\ShowingFormat;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ShowingFormatExtension extends AbstractExtension
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
            new TwigFunction('showing_format_voice_text', [$this, 'getVoiceText']),
        ];
    }

    public function getVoiceText(int $voice): string
    {
        switch ($voice) {
            case ShowingFormat::VOICE_SUBTITLE:
                return '字幕版';

            case ShowingFormat::VOICE_DUB:
                return '吹替版';

            default:
                return '';
        }
    }
}
