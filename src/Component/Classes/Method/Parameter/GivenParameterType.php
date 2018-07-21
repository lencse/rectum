<?php

namespace Lencse\Rectum\Component\Classes\Method\Parameter;

class GivenParameterType implements ParameterType
{

    /**
     * @var string
     */
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function match(string $type): bool
    {
        return $this->type === $type;
    }
}
