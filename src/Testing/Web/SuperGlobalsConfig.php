<?php

namespace Lencse\Rectum\Testing\Web;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\Request\FromGlobalsRequestReader;
use Lencse\Rectum\Component\Web\Response\ResponseRenderer;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;

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
