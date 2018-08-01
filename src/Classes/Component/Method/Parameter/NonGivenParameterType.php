<?php

namespace Lencse\Rectum\Classes\Component\Method\Parameter;

class NonGivenParameterType implements ParameterType
{
    public function match(string $type): bool
    {
        return false;
    }
}
