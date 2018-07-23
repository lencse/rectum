<?php

namespace Lencse\Rectum\Framework\DependencyInjection;

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
