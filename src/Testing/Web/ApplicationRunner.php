<?php

namespace Lencse\Rectum\Testing\Web;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\Configuration\CompositeApplicationConfig;
use Lencse\Rectum\Framework\Application\Bootstrap;
use Lencse\Rectum\Testing\Web\Response\ResponseObserver;
use Psr\Http\Message\ResponseInterface;

class ApplicationRunner
{

    /**
     * @var string
     */
    private $projectRoot;

    public function __construct(string $projectRoot)
    {
        $this->projectRoot = $projectRoot;
    }

    public function runWithSuperGlobals(array $globals): ResponseInterface
    {
        $responseObserver = new ResponseObserver();
        $bootstrap = new Bootstrap(new CompositeApplicationConfig([
            require $this->projectRoot . '/bootstrap/configuration.php',
            new ObserverConfig($globals, $responseObserver)
        ]));
        $bootstrap->createWebApplication()->run();

        return $responseObserver->getResponse();
    }
}
