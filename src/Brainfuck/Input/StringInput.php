<?php

declare(strict_types=1);

namespace Brainfuck\Input;

class StringInput implements InputInterface
{
    private int $position = 0;

    public function __construct(private readonly string $string)
    {
    }

    public function read(): string
    {
        return $this->string[$this->position++] ?? "\0";
    }
}
