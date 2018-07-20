<?php

namespace Lencse\Rectum\Framework\Application;

use Lencse\Rectum\Component\DependencyInjection\Configuration\CompositeDependencyInjectionConfig;
use Lencse\Rectum\Component\DependencyInjection\Container;
use Lencse\Rectum\Component\Web\WebApplication;
use Lencse\Rectum\Framework\Classes\ClassesDI;
use Lencse\Rectum\Framework\DependencyInjection\AurynContainerFactory;
use Lencse\Rectum\Framework\DependencyInjection\AurynParameterTransformer;
use Lencse\Rectum\Framework\Routing\RoutingDI;
use Lencse\Rectum\Framework\Web\WebDI;

class Bootstrap
{

    /**
     * @var Container
     */
    private $dic;

    public function __construct()
    {
        $factory = new AurynContainerFactory(new AurynParameterTransformer());
        $this->dic = $factory->createContainer(new CompositeDependencyInjectionConfig([
            new ClassesDI(),
            new RoutingDI(),
            new WebDI()
        ]));
    }

    public function createWebApplication(): WebApplication
    {
        /** @var WebApplication $app */
        $app = $this->dic->make(WebApplication::class);
        return $app;
    }
}
