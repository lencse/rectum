<?php

namespace Lencse\Rectum\Component\Web;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class RequestReader
{

    public function createFromGlobals(array $serverArr, array $getArr): ServerRequestInterface
    {
        $request = new ServerRequest(
            (string) $serverArr['REQUEST_METHOD'],
            (string) $serverArr['REQUEST_URI']
        );

        return $request->withQueryParams($getArr);
    }
}
