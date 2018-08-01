<?php

namespace Lencse\Rectum\Classes\Component\Method\Parameter;

use Lencse\Rectum\Classes\Component\Method\Parameter\ParameterType;

class NonGivenParameterType implements ParameterType
{
    public function match(string $type): bool
    {
        return false;
    }
}
