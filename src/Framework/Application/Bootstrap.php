<?php

namespace Lencse\Rectum\Framework\Application;

use Lencse\Rectum\Component\DependencyInjection\Configuration\CompositeDependencyInjectionConfig;
use Lencse\Rectum\Component\Web\WebApplication;
use Lencse\Rectum\Framework\Classes\ClassesDI;
use Lencse\Rectum\Framework\DependencyInjection\AurynContainerFactory;
use Lencse\Rectum\Framework\DependencyInjection\AurynParameterTransformer;
use Lencse\Rectum\Framework\Web\Request\RequestDI;
use Lencse\Rectum\Framework\Web\RequestHandler\RequestHandlerDI;
use Lencse\Rectum\Framework\Web\Routing\RoutingDI;
use Lencse\Rectum\Framework\Web\Response\ResponseDI;
use Psr\Container\ContainerInterface;

class Bootstrap
{

    /**
     * @var ContainerInterface
     */
    private $dic;

    public function __construct()
    {
        $factory = new AurynContainerFactory(new AurynParameterTransformer());
        $this->dic = $factory->createContainer(new CompositeDependencyInjectionConfig([
            new ClassesDI(),
            new RequestDI(),
            new RequestHandlerDI(),
            new ResponseDI(),
            new RoutingDI(),
        ]));
    }

    public function createWebApplication(): WebApplication
    {
        /** @var WebApplication $app */
        $app = $this->dic->get(WebApplication::class);

        return $app;
    }
}
