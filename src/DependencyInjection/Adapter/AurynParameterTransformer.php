<?php

namespace Lencse\Rectum\DependencyInjection\Adapter;

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
