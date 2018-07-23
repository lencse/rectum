<?php

namespace App;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\Request\FromGlobalsRequestReader;
use Lencse\Rectum\Component\Web\Response\ResponseRenderer;
use Lencse\Rectum\Framework\Application\Bootstrap;
use Test\Integration\MockRenderer;

return function (array $globals): Bootstrap {
    $config = require 'configuration.php';

    $dicExtra = new class ($globals) implements DependencyInjectionConfig
    {

        /**
         * @var array
         */
        private $globals;

        public function __construct(array $globals)
        {
            $this->globals = $globals;
        }

        public function bind(): array
        {
            return [
                ResponseRenderer::class => MockRenderer::class
            ];
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
            return [];
        }
    };

    return new Bootstrap($config($dicExtra));
};
