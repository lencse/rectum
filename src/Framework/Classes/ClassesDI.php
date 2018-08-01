<?php

namespace Lencse\Rectum\Framework\Classes;

use Lencse\Rectum\Classes\Adapter\Method\Parameter\ReflectionMethodParameterAnalyzer;
use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;

class ClassesDI implements DependencyInjectionConfig
{
    public function bind(): array
    {
        return [
            MethodParameterAnalyzer::class => ReflectionMethodParameterAnalyzer::class,
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
}
