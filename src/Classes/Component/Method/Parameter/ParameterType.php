<?php

namespace Lencse\Rectum\Classes\Component\Method\Parameter;

interface ParameterType
{
    public function match(string $type): bool;
}
