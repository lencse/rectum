<?php

namespace Lencse\Rectum\Adapter\Web\Request;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Web\Request\RequestReader;
use Psr\Http\Message\ServerRequestInterface;

class FromGlobalsRequestReader implements RequestReader
{

    /**
     * @var array
     */
    private $serverArr;

    /**
     * @var array
     */
    private $getArr;

    public function __construct(array $serverArr, array $getArr)
    {
        $this->serverArr = $serverArr;
        $this->getArr = $getArr;
    }

    public function create(): ServerRequestInterface
    {
        $request = new ServerRequest(
            (string) $this->serverArr['REQUEST_METHOD'],
            (string) $this->serverArr['REQUEST_URI']
        );

        return $request->withQueryParams($this->getArr);
    }
}
