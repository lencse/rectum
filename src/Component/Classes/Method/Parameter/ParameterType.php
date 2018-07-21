<?php

namespace Lencse\Rectum\Component\Classes\Method\Parameter;

interface ParameterType
{

    public function match(string $type): bool;
}
