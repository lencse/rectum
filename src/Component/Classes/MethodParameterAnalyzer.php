<?php

namespace Lencse\Rectum\Component\Classes;

interface MethodParameterAnalyzer
{

    /**
     * @param string $class
     * @param string $method
     * @return MethodParameter[]
     */
    public function getParameters(string $class, string $method): array;
}
