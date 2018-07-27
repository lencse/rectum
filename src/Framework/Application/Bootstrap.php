<?php

namespace Lencse\Rectum\Framework\Application;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\DependencyInjection\Configuration\CompositeDependencyInjectionConfig;
use Lencse\Rectum\Component\Web\WebApplication;
use Lencse\Rectum\Framework\Classes\ClassesDI;
use Lencse\Rectum\Adapter\Classes\Method\Parameter\ReflectionMethodParameterAnalyzer;
use Lencse\Rectum\Adapter\DependencyInjection\AurynContainerFactory;
use Lencse\Rectum\Adapter\DependencyInjection\AurynParameterTransformer;
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

    public function __construct(ApplicationConfig $config)
    {
        $factory = new AurynContainerFactory(new AurynParameterTransformer(), new ReflectionMethodParameterAnalyzer());
        $this->dic = $factory->createContainer(new CompositeDependencyInjectionConfig([
            new ClassesDI(),
            new RequestDI(),
            new RequestHandlerDI(),
            new ResponseDI(),
            new RoutingDI($config->routingConfig()),
            $config->dependencyInjectionConfig(),
        ]));
    }

    public function createWebApplication(): WebApplication
    {
        return $this->dic->get(WebApplication::class);
    }
}
