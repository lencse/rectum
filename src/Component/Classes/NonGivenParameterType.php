<?php

namespace Lencse\Rectum\Component\Classes;

class NonGivenParameterType implements ParameterType
{

    public function match(string $type): bool
    {
        return false;
    }
}
