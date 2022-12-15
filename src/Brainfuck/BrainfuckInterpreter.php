<?php

declare(strict_types=1);

namespace Brainfuck;

use Brainfuck\Input\InputInterface;
use InvalidArgumentException;

class BrainfuckInterpreter
{
    public function __construct(
        private readonly InputInterface $input,
        private readonly int $memoryLimit,
        private readonly bool $debug = false
    ) {
    }

    public function run(string $code): string
    {
        $pointer = 0;
        $memory = array_fill(0, $this->memoryLimit, 0);
        $loops = [];
        $codeLength = strlen($code);
        $output = '';

        for ($i = 0; $i < $codeLength; $i++) {
            if ($this->debug) {
                echo($code . PHP_EOL . str_repeat(' ', $i) . '^ ' . $memory[$pointer] . ' @' . $pointer . PHP_EOL . PHP_EOL);
            }

            $command = $code[$i];

            switch ($command) {
                case '>':
                    $pointer = ($pointer + 1) % $this->memoryLimit;
                    break;
                case '<':
                    $pointer = ($pointer - 1 + $this->memoryLimit) % $this->memoryLimit;
                    break;
                case '+':
                    $memory[$pointer] = ($memory[$pointer] + 1) % 256;
                    break;
                case '-':
                    $memory[$pointer] = ($memory[$pointer] - 1 + 256) % 256;
                    break;
                case '.':
                    $output .= chr($memory[$pointer]);
                    break;
                case ',':
                    $memory[$pointer] = ord($this->input->read());
                    break;
                case '[':
                    if ($memory[$pointer]) {
                        $loops[] = $i - 1;
                    } else {
                        for ($d = 1; $d > 0; ) {
                            $i++;

                            $d += $code[$i] === '[';
                            $d -= $code[$i] === ']';
                        }
                    }

                    break;
                case ']':
                    $i = array_pop($loops);
                    break;

                default:
                    throw new InvalidArgumentException("Command '{$command}' is invalid");
            }
        }

        return $output;
    }
}
