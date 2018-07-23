<?php

namespace App;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\DependencyInjection\Configuration\CompositeDependencyInjectionConfig;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;

return function (DependencyInjectionConfig $dicExtra): ApplicationConfig {
    return new class ($dicExtra) implements ApplicationConfig
    {

        /**
         * @var DependencyInjectionConfig
         */
        private $dicExtra;

        public function __construct(DependencyInjectionConfig $dicExtra)
        {
            $this->dicExtra = $dicExtra;
        }

        public function dependencyInjectionConfig(): DependencyInjectionConfig
        {
            return new CompositeDependencyInjectionConfig([
                require __DIR__ . '/../config/dic.php',
                $this->dicExtra,
            ]);
        }

        public function routingConfig(): RoutingConfig
        {
            return require __DIR__ . '/../config/routing.php';
        }
    };
};
