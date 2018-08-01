<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

interface DependencyInjectionConfig
{
    public function bind(): array;

    public function factory(): array;

    public function setup(): array;

    public function wire(): array;

    public function instance(): array;
}
