<?php

namespace Lencse\Rectum\Framework\Classes;

use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Framework\Classes\Method\Parameter\ReflectionMethodParameterAnalyzer;

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
