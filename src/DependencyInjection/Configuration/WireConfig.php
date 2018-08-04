<?php

namespace Lencse\Rectum\DependencyInjection\Configuration;

class WireConfig
{
    /**
     * @var string
     */
    private $parameterName;

    /**
     * @var string
     */
    private $className;

    public function __construct(string $parameterName, string $className)
    {
        $this->parameterName = $parameterName;
        $this->className = $className;
    }

    public function getParameterName(): string
    {
        return $this->parameterName;
    }

    public function getClassName(): string
    {
        return $this->className;
    }
}
