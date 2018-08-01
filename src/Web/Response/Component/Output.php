<?php

namespace Lencse\Rectum\Web\Response\Component;

interface Output
{
    public function print(string $content): void;
}
