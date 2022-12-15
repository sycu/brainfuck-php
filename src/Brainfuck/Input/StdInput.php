<?php

declare(strict_types=1);

namespace Brainfuck\Input;

class StdInput implements InputInterface
{
    public function read(): string
    {
        return fread(STDIN, 1);
    }
}
