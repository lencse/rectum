<?php

namespace Lencse\Rectum\Classes\Component\Invoking;

interface Invoker
{
    /**
     * @param string $invokableClass
     * @param mixed[] $params
     *
     * @return mixed
     */
    public function invoke(string $invokableClass, array $params = []);
}
