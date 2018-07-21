<?php

namespace Lencse\Rectum\Component\Classes\Method\Parameter;

class MethodParameter
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var ParameterType
     */
    private $type;

    public function __construct(string $name, ParameterType $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ParameterType
    {
        return $this->type;
    }
}
