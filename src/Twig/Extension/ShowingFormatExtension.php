<?php

namespace App\Twig\Extension;

use App\ORM\Entity\ShowingFormat;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * ShowingFormat twig extension class
 */
class ShowingFormatExtension extends AbstractExtension
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
            new TwigFunction('showing_format_voice_text', [$this, 'getVoiceText']),
        ];
    }

    /**
     * return voice text
     *
     * @param int $voice
     * @return string
     */
    public function getVoiceText(int $voice)
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
