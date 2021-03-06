<?php

namespace Lencse\Rectum\Classes\Adapter\Method\Parameter;

use Lencse\Rectum\Classes\Component\Method\Parameter\GivenParameterType;
use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameter;
use Lencse\Rectum\Classes\Component\Method\Parameter\MethodParameterAnalyzer;
use Lencse\Rectum\Classes\Component\Method\Parameter\NonGivenParameterType;
use ReflectionClass;
use ReflectionParameter;

class ReflectionMethodParameterAnalyzer implements MethodParameterAnalyzer
{
    /**
     * @param string $class
     * @param string $method
     *
     * @return MethodParameter[]
     */
    public function getParameters(string $class, string $method): array
    {
        $reflection = new ReflectionClass($class);
        /** @var ReflectionParameter[] $handlerParams */
        $handlerParams = $reflection->getMethod($method)->getParameters();

        return array_map(function (ReflectionParameter $param) use ($class): MethodParameter {
            if (empty($param->getType())) {
                return new MethodParameter($param->getName(), new NonGivenParameterType());
            }

            return new MethodParameter(
                $param->getName(),
                new GivenParameterType(
                    'self' === $param->getType()->getName() ?
                        $class :
                        $param->getType()->getName()
                )
            );
        }, $handlerParams);
    }
}
