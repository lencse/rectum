<?php

namespace Lencse\Rectum\Classes\Component\Invoking;

use Lencse\Rectum\Classes\Component\Method\Parameter\ActualParameterCollection;

interface Invoker2
{
    public function invoke(string $invokableClass, ActualParameterCollection $params);

    public function invokeWithOneParameter(string $invokableClass, $param);
}
