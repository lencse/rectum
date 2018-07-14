<?php

namespace Lencse\Rectum\Component\DependencyInjection\Configuration;

use Lencse\Rectum\Component\DependencyInjection\Container;

interface DependencyInjectionSetup
{

    public function createContainer(): Container;

    /**
     * @return string[]
     */
    public function injectSelf(): array;
}
