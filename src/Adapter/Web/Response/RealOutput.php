<?php

namespace Lencse\Rectum\Adapter\Web\Response;

use Lencse\Rectum\Component\Web\Response\Output;

class RealOutput implements Output
{

    public function print(string $content): void
    {
        echo $content;
    }
}
