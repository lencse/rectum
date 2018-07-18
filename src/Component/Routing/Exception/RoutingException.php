<?php

namespace Lencse\Rectum\Component\Routing\Exception;

use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

abstract class RoutingException extends RuntimeException
{

    /**
     * @var ServerRequestInterface
     */
    private $request;

    protected function __construct(ServerRequestInterface $request)
    {
        parent::__construct($this->createMessage($request), $this->getHttpCode());
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public static function create(ServerRequestInterface $request): self
    {
        $class = static::class;
        return new $class($request);
    }

    abstract protected function createMessage(ServerRequestInterface $request): string;

    abstract  protected function getHttpCode(): int;
}
