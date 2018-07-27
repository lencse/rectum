<?php

namespace Test\App;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use TestApp\Handler\OkMessage;
use TestApp\Handler\TestMessage;

return new class() implements DependencyInjectionConfig {
    public function bind(): array
    {
        return [
            TestMessage::class => OkMessage::class
        ];
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

    public function instance(): array
    {
        return [];
    }
};
