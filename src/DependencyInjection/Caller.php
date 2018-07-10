<?php

namespace Lencse\Rectum\DependencyInjection;

interface Caller
{

    /**
     * @param string $callableClass
     * @param mixed[] $params
     * @return mixed
     */
    public function call(string $callableClass, array $params = []);
}
