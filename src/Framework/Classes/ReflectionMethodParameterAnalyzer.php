<?php

namespace Lencse\Rectum\Framework\Classes;

use Lencse\Rectum\Component\Classes\GivenParameterType;
use Lencse\Rectum\Component\Classes\MethodParameter;
use Lencse\Rectum\Component\Classes\MethodParameterAnalyzer;
use Lencse\Rectum\Component\Classes\NonGivenParameterType;
use ReflectionClass;
use ReflectionParameter;

class ReflectionMethodParameterAnalyzer implements MethodParameterAnalyzer
{

    /**
     * @param string $class
     * @param string $method
     * @return MethodParameter[]
     */
    public function getParameters(string $class, string $method): array
    {
        $reflection = new ReflectionClass($class);
        /** @var ReflectionParameter[] $handlerParams */
        $handlerParams = $reflection->getMethod($method)->getParameters();

        return array_map(function (ReflectionParameter $param): MethodParameter {
            $type = empty($param->getType()) ?
                new NonGivenParameterType() :
                new GivenParameterType($param->getType()->getName());

            return new MethodParameter($param->getName(), $type);
        }, $handlerParams);
    }
}
