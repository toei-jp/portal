<?php
/**
 * TitleExtension.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Twig\Extension;

use Psr\Container\ContainerInterface;

use Toei\Portal\ORM\Entity\Title;

/**
 * Title twig extension class
 */
class TitleExtension extends \Twig_Extension
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
            new \Twig_Function('title_rating_text', [$this, 'getRatingText']),
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
        if (Title::RATING_G === $rating) {
            return 'G';
        } elseif (Title::RATING_PG12 === $rating) {
            return 'PG12';
        } elseif (Title::RATING_R15 === $rating) {
            return 'R15+';
        } elseif (Title::RATING_R18 === $rating) {
            return 'R18+';
        }
        
        return '';
    }
}
