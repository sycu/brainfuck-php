<?php

declare(strict_types=1);

namespace Brainfuck\Input;

interface InputInterface
{
    public function read(): string;
}
