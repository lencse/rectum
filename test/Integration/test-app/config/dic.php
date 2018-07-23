<?php

namespace Test\App;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;

return new class implements DependencyInjectionConfig
{

    public function bind(): array
    {
        return [];
    }

    public function factory(): array
    {
        return [];
    }

    public function setup(): array
    {
        return [];
    }

    public function wire(): array
    {
        return [];
    }
};
