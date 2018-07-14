<?php

namespace Lencse\Rectum\Framework\DependencyInjection;

use Lencse\Rectum\Component\DependencyInjection\Caller;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionSetup;
use Lencse\Rectum\Component\DependencyInjection\Container;

class DefaultSetup implements DependencyInjectionSetup
{

    public function createContainer(): Container
    {
        return new AurynContainer();
    }

    public function injectSelf(): array
    {
        return [
            Caller::class
        ];
    }
}
