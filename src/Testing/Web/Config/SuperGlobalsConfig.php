<?php

namespace Lencse\Rectum\Testing\Web\Config;

use Lencse\Rectum\Adapter\Web\Request\FromGlobalsRequestReader;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;

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
            FromGlobalsRequestReader::class => [
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
