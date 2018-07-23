<?php

namespace Lencse\Rectum\Framework\Classes\Method\Parameter;

use Lencse\Rectum\Component\Classes\Method\Parameter\GivenParameterType;
use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameter;
use Lencse\Rectum\Component\Classes\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\Component\Classes\Method\Parameter\NonGivenParameterType;
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
