<?php

namespace Lencse\Rectum\DependencyInjection;

interface Caller
{

    /**
     * @param string $callableClass
     * @param mixed[] $params
     * @return object|array
     */
    public function call(string $callableClass, array $params = []);
}
