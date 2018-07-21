<?php

namespace Lencse\Rectum\Component\Classes\Invoking;

interface Invoker
{

    /**
     * @param string $invokableClass
     * @param mixed[] $params
     * @return mixed
     */
    public function invoke(string $invokableClass, array $params = []);
}
