<?php

namespace Lencse\Rectum\Classes\Component\Method\Parameter;

class ActualParameter
{
    /**
     * @var string
     */
    private $name;

    private $value;

    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}
