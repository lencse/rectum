<?php

namespace Lencse\Rectum\Classes\Component\Method\Parameter;

interface MethodParameterAnalyzer
{
    /**
     * @param string $class
     * @param string $method
     *
     * @return FormalParameter[]
     */
    public function getParameters(string $class, string $method): array;
}
