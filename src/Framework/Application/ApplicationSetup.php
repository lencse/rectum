<?php

namespace Lencse\Rectum\Framework\Application;

use Lencse\Rectum\Application\Configuration\ApplicationConfig;
use Lencse\Rectum\Classes\Adapter\Method\Parameter\ReflectionMethodParameterAnalyzer;
use Lencse\Rectum\DependencyInjection\Adapter\AurynContainerFactory;
use Lencse\Rectum\DependencyInjection\Adapter\AurynParameterTransformer;
use Lencse\Rectum\DependencyInjection\Configuration\CompositeDependencyInjectionConfig;
use Lencse\Rectum\Framework\Classes\ClassesDI;
use Lencse\Rectum\Framework\Web\Request\RequestDI;
use Lencse\Rectum\Framework\Web\RequestHandler\RequestHandlerDI;
use Lencse\Rectum\Framework\Web\Response\ResponseDI;
use Lencse\Rectum\Framework\Web\Routing\RoutingDI;
use Lencse\Rectum\Web\Application\Component\WebApplication;
use Psr\Container\ContainerInterface;

class ApplicationSetup
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
