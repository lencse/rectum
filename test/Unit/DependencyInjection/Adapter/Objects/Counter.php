<?php

namespace Test\Unit\DependencyInjection\Adapter\Objects;

class Counter
{
    /**
     * @var int
     */
    private $count = 0;

    public function __invoke(): int
    {
        return ++$this->count;
    }
}
