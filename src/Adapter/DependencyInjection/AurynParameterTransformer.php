<?php

namespace Lencse\Rectum\Adapter\DependencyInjection;

class AurynParameterTransformer
{
    public function transformParameters(array $params): array
    {
        $result = [];
        foreach ($params as $key => $value) {
            $result[":$key"] = $value;
        }

        return $result;
    }
}
