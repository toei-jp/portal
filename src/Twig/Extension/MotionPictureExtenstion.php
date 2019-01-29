<?php
/**
 * MotionPictureExtenstion.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Twig\Extension;

use Psr\Container\ContainerInterface;

/**
 * MotionPicture twig extension class
 */
class MotionPictureExtenstion extends \Twig_Extension
{
    /** @var array */
    protected $settings;
    
    /**
     * construct
     * 
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->settings = $container->get('settings')['mp'];
    }
    
    /**
     * get functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('mp_api_endpoint', [$this, 'getApiEndpoint']),
            new \Twig_Function('mp_waiter_server_url', [$this, 'getWaiterServerUrl']),
            new \Twig_Function('mp_ticket_site_url', [$this, 'getTicketSiteUrl']),
            new \Twig_Function('mp_project_id', [$this, 'getProjectId']),
        ];
    }
    
    /**
     * return API endpoint
     *
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->settings['api_endpoint'];
    }
    
    /**
     * return waiter server URL
     *
     * @return string
     */
    public function getWaiterServerUrl(): string
    {
        return $this->settings['waiter_server_url'];
    }
    
    /**
     * return ticket site URL
     *
     * @return string
     */
    public function getTicketSiteUrl(): string
    {
        return $this->settings['ticket_site_url'];
    }
    
    /**
     * return project ID
     *
     * @return string
     */
    public function getProjectId(): string
    {
        return $this->settings['project_id'];
    }
}