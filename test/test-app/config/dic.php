<?php

namespace Test\App;

use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use TestApp\UseCase\Ok\OkMessage;
use TestApp\UseCase\Ok\TestMessage;

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
