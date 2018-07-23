<?php

namespace App;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\Configuration\CompositeApplicationConfig;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\Request\FromGlobalsRequestReader;
use Lencse\Rectum\Component\Web\Response\ResponseRenderer;
use Lencse\Rectum\Framework\Application\Bootstrap;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;

return function (array $globals, ResponseRenderer $responseRenderer): Bootstrap {
    $config = require 'configuration.php';

    $extra = new class ($globals, $responseRenderer) implements ApplicationConfig
    {

        /**
         * @var array
         */
        private $globals;

        /**
         * @var ResponseRenderer
         */
        private $responseRenderer;

        public function __construct(array $globals, ResponseRenderer $responseRenderer)
        {
            $this->globals = $globals;
            $this->responseRenderer = $responseRenderer;
        }

        public function dependencyInjectionConfig(): DependencyInjectionConfig
        {
            return new class ($this->globals, $this->responseRenderer) implements DependencyInjectionConfig
            {
                /**
                 * @var array
                 */
                private $globals;

                /**
                 * @var ResponseRenderer
                 */
                private $responseRenderer;

                public function __construct(array $globals, ResponseRenderer $responseRenderer)
                {
                    $this->globals = $globals;
                    $this->responseRenderer = $responseRenderer;
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
                            'serverArr' => $this->globals['SERVER'],
                            'getArr' => $this->globals['GET'],
                        ]
                    ];
                }

                public function wire(): array
                {
                    return [];
                }

                public function instance(): array
                {
                    return [
                        ResponseRenderer::class => $this->responseRenderer
                    ];
                }
            };
        }

        public function routingConfig(): RoutingConfig
        {
            return new class implements RoutingConfig
            {
                public function routes(): array
                {
                    return [];
                }
            };
        }
    };

    return new Bootstrap(new CompositeApplicationConfig([$config, $extra]));
};
