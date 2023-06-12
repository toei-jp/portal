<?php

declare(strict_types=1);

namespace App\Session;

use Laminas\Session\Container as BaseContainer;

class Container extends BaseContainer
{
    public function clear(): void
    {
        $this->getStorage()->clear($this->getName());
    }
}
