<?php

namespace Lencse\Rectum\Component\DependencyInjection;

interface Invoker
{

    /**
     * @param string $invokableClass
     * @param mixed[] $params
     * @return mixed
     */
    public function call(string $invokableClass, array $params = []);
}