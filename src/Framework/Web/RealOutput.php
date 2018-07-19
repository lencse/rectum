<?php

namespace Lencse\Rectum\Framework\Web;

use Lencse\Rectum\Component\Web\Output;

class RealOutput implements Output
{

    public function print(string $content): void
    {
        echo $content;
    }
}
