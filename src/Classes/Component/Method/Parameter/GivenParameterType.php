<?php

namespace Lencse\Rectum\Classes\Component\Method\Parameter;

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
