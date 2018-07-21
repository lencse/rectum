<?php

namespace Lencse\Rectum\Component\Web\Request;

use GuzzleHttp\Psr7\ServerRequest;
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
