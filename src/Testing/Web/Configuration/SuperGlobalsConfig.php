<?php

namespace Lencse\Rectum\Testing\Web\Configuration;

use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Request\Adapter\FromGlobalsRequestSource;

class SuperGlobalsConfig implements DependencyInjectionConfig
{
    /**
     * @var array
     */
    private $superGlobals;

    public function __construct(array $superGlobals)
    {
        $this->superGlobals = $superGlobals;
    }

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
        return [
            FromGlobalsRequestSource::class => [
                'serverArr' => $this->superGlobals['SERVER'],
                'getArr' => $this->superGlobals['GET'],
            ]
        ];
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
