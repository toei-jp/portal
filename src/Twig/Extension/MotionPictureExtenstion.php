<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MotionPictureExtenstion extends AbstractExtension
{
    /** @var array<string, mixed> */
    protected $settings;

    /**
     * @param array<string, mixed> $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('mp_api_endpoint', [$this, 'getApiEndpoint']),
            new TwigFunction('mp_waiter_server_url', [$this, 'getWaiterServerUrl']),
            new TwigFunction('mp_ticket_site_url', [$this, 'getTicketSiteUrl']),
            new TwigFunction('mp_project_id', [$this, 'getProjectId']),
        ];
    }

    public function getApiEndpoint(): string
    {
        return $this->settings['api_endpoint'];
    }

    public function getWaiterServerUrl(): string
    {
        return $this->settings['waiter_server_url'];
    }

    public function getTicketSiteUrl(): string
    {
        return $this->settings['ticket_site_url'];
    }

    public function getProjectId(): string
    {
        return $this->settings['project_id'];
    }
}
