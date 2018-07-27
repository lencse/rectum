<?php

namespace Lencse\Rectum\Component\DependencyInjection\Configuration;

interface DependencyInjectionConfig
{
    public function bind(): array;

    public function factory(): array;

    public function setup(): array;

    public function wire(): array;

    public function instance(): array;
}
