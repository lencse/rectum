<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

use Lencse\Rectum\DependencyInjection\Container;

interface DependencyInjectionSetup
{

    public function createContainer(): Container;

    /**
     * @return string[]
     */
    public function injectSelf(): array;
}
