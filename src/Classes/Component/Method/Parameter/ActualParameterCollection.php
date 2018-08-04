<?php

namespace Lencse\Rectum\Classes\Component\Method\Parameter;

class ActualParameterCollection implements \Iterator
{
    /**
     * @var ActualParameter[]
     */
    private $parameters = [];

    public function add(ActualParameter $parameter): self
    {
        $result = new self();
        $result->parameters = array_merge($this->parameters, [$parameter]);

        return $result;
    }

    public function current(): ActualParameter
    {
        return current($this->parameters);
    }

    /**
     * @return false|ActualParameter
     */
    public function next()
    {
        return next($this->parameters);
    }

    public function key()
    {
        return key($this->parameters);
    }

    public function valid(): bool
    {
        return null !== key($this->parameters) && false !== key($this->parameters);
    }

    public function rewind(): void
    {
        reset($this->parameters);
    }
}
