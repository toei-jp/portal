<?php

/**
 * ShowingFormatExtension.php
 */

namespace Toei\Portal\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Toei\Portal\ORM\Entity\ShowingFormat;

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
        if (ShowingFormat::VOICE_SUBTITLE === $voice) {
            return '字幕版';
        } elseif (ShowingFormat::VOICE_DUB === $voice) {
            return '吹替版';
        }

        return '';
    }
}
