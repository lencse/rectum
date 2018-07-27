<?php

namespace Lencse\Rectum\Testing\Web;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\Request\RequestReader;
use Psr\Http\Message\ServerRequestInterface;

class RequestConfig implements DependencyInjectionConfig
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function bind(): array
    {
        return [];
    }

    public function factory(): array
    {
        return [];
    }

    public function setup(): array
    {
        return [];
    }

    public function wire(): array
    {
        return [];
    }

    public function instance(): array
    {
        return [
            RequestReader::class => new class ($this->request) implements RequestReader {
                /**
                 * @var ServerRequestInterface
                 */
                private $request;

                public function __construct(ServerRequestInterface $request)
                {
                    $this->request = $request;
                }

                public function create(): ServerRequestInterface
                {
                    return $this->request;
                }
            }
        ];
    }
}
