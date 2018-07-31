<?php

namespace Lencse\Rectum\Component\Web\Http;

/**
 * @SuppressWarnings(PHPMD)
 */
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

    public static function head(): self
    {
        return new self('HEAD');
    }

    public static function get(): self
    {
        return new self('GET');
    }

    public static function post(): self
    {
        return new self('POST');
    }

    public static function put(): self
    {
        return new self('PUT');
    }

    public static function patch(): self
    {
        return new self('PATCH');
    }

    public static function delete(): self
    {
        return new self('DELETE');
    }

    public static function purge(): self
    {
        return new self('PURGE');
    }

    public static function options(): self
    {
        return new self('OPTIONS');
    }

    public static function trace(): self
    {
        return new self('TRACE');
    }

    public static function connect(): self
    {
        return new self('CONNECT');
    }
}
