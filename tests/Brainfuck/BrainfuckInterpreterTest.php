<?php

declare(strict_types=1);

namespace Tests\Brainfuck;

use Brainfuck\BrainfuckInterpreter;
use Brainfuck\Input\StringInput;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BrainfuckInterpreterTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testRunExecutesCodeAndReturnsOutput(string $code, string $input, string $expected): void
    {
        $interpreter = new BrainfuckInterpreter(new StringInput($input), 256);

        $r = $interpreter->run($code);

        $this->assertSame($expected, $r);
    }

    public function dataProvider(): array
    {
        return [
            'Hello World 1' => [
                'code' => '++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.',
                'input' => '',
                'expected' => "Hello World!\n",
            ],
            'Hello World 2' => [
                'code' => '++++++++[>++++[>++>+++>+++>+<<<<-]>+>+>->>+[<]<-]>>.>---.+++++++..+++.>>.<-.<.+++.------.--------.>>+.>++.',
                'input' => '',
                'expected' => "Hello World!\n",
            ],
            'Input to output' => [
                'code' => '>,[.>,]',
                'input' => "foo bar\0",
                'expected' => 'foo bar',
            ],
            'YouTube2014! BF' => [
                'code' => '-[+>+>+[+<]>+]>[[>]+[+++<]>]>+.>-.++++++.<-----.>.>>--.+++.>>>>>>>>--.--.+.+++.>>>-.-.<<<<<++.<.',
                'input' => '',
                'expected' => 'YouTube2014! BF',
            ],
        ];
    }

    public function testRunThrowsExceptionWhenCodeContainsInvalidCommand(): void
    {
        $interpreter = new BrainfuckInterpreter(new StringInput(''), 256);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Command 'X' is invalid");

        $interpreter->run('X');
    }
}
