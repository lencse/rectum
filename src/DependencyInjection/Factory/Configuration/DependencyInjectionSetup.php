<?php

namespace Lencse\Rectum\DependencyInjection\Factory\Configuration;

use Lencse\Rectum\DependencyInjection\Container;

interface DependencyInjectionSetup
{

    public function createContainer(): Container;

    /**
     * @return string[]
     */
    public function injectSelf(): array;
}
