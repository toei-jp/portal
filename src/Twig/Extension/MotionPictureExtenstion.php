<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * MotionPicture twig extension class
 */
class MotionPictureExtenstion extends AbstractExtension
{
    /** @var array */
    protected $settings;

    /**
     * construct
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * get functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('mp_api_endpoint', [$this, 'getApiEndpoint']),
            new TwigFunction('mp_waiter_server_url', [$this, 'getWaiterServerUrl']),
            new TwigFunction('mp_ticket_site_url', [$this, 'getTicketSiteUrl']),
            new TwigFunction('mp_project_id', [$this, 'getProjectId']),
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
