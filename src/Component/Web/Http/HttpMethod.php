<?php

namespace Lencse\Rectum\Component\Web\Http;

class HttpMethod
{

    /**
     * @var string
     */
    private $method;

    private function __construct(string $method)
    {
        $this->method = $method;
    }

    public function __toString()
    {
        return $this->method;
    }

    public static function get(): self
    {
        return new self('GET');
    }

    public static function post(): self
    {
        return new self('POST');
    }
}
