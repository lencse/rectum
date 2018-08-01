<?php

namespace Lencse\Rectum\Classes\Component\Method\Parameter;

use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameter;

interface MethodParameterAnalyzer
{
    /**
     * @param string $class
     * @param string $method
     *
     * @return MethodParameter[]
     */
    public function getParameters(string $class, string $method): array;
}
