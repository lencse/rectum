<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

class BindConfig implements Config
{
    /**
     * @var string
     */
    private $abstract;

    /**
     * @var string
     */
    private $concrete;

    public function __construct(string $abstract, string $concrete)
    {
        $this->abstract = $abstract;
        $this->concrete = $concrete;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
    }

    public function getConcrete(): string
    {
        return $this->concrete;
    }

    public function applyOnContainerBuilder(ContainerBuilder $builder): void
    {
        $builder->bind($this);
    }
}
