<?php

namespace Lencse\Rectum\Component\DependencyInjection;

interface Caller
{

    /**
     * @param string $callableClass
     * @param mixed[] $params
     * @return mixed
     */
    public function call(string $callableClass, array $params = []);
}
