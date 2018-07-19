<?php

namespace Lencse\Rectum\Component\Classes;

interface ParameterType
{

    public function match(string $type): bool;
}
