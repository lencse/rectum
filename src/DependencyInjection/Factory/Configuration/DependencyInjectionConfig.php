<?php

namespace Lencse\Rectum\DependencyInjection\Factory\Configuration;

interface DependencyInjectionConfig
{

    /**
     * @return string[]
     */
    public function bind(): array;

    /**
     * @return string[]
     */
    public function factory(): array;

    /**
     * @return mixed[][]
     */
    public function setup(): array;
}
