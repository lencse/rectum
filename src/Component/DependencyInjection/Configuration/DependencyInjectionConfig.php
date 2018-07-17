<?php

namespace Lencse\Rectum\Component\DependencyInjection\Configuration;

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

    /**
     * @return mixed[][]
     */
    public function wire(): array;
}
