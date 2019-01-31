<?php
/**
 * ShowingFormatExtension.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Twig\Extension;

use Psr\Container\ContainerInterface;

use Toei\Portal\ORM\Entity\ShowingFormat;

/**
 * ShowingFormat twig extension class
 */
class ShowingFormatExtension extends \Twig_Extension
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
            new \Twig_Function('showing_format_voice_text', [$this, 'getVoiceText']),
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
        } else if (ShowingFormat::VOICE_DUB === $voice) {
            return '吹替版';
        }
        
        return '';
    }
}