<?php

declare(strict_types=1);

namespace App\Session;

use Laminas\Session\Config\ConfigInterface;
use Laminas\Session\SessionManager as BaseSessionManager;

class SessionManager extends BaseSessionManager
{
    /** @var Container[] */
    protected array $containers = [];

    public function __construct(ConfigInterface $config)
    {
        parent::__construct($config);

        Container::setDefaultManager($this);
    }

    public function getContainer(string $name = 'default'): Container
    {
        if (! isset($this->containers[$name])) {
            $this->containers[$name] = new Container($name);
        }

        return $this->containers[$name];
    }
}
