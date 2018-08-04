<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

interface Config
{
    public function applyOnContainerBuilder(ContainerBuilder $builder): void;
}
