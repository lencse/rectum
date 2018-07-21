<?php

namespace Lencse\Rectum\Component\Classes\Method\Parameter;

class NonGivenParameterType implements ParameterType
{

    public function match(string $type): bool
    {
        return false;
    }
}
