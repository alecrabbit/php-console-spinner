<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Frame\StyleFrame;
use AlecRabbit\Tests\Spinner\TestCase;

use TypeError;

use const AlecRabbit\Cli\CSI;
use const AlecRabbit\Cli\RESET;

class StyleTest extends TestCase
{
    protected const STYLE = CSI . '01;04;38;5;39m%s' . RESET;

    public function createDataProvider(): iterable
    {
        // [$expected, $element]
        yield [
            [
                self::SEQUENCE_START => '',
                self::SEQUENCE_END => '',
                self::CONTAINS => '',
            ],
            ['', ''],
        ];

        yield [
            [
                self::SEQUENCE_START => '>',
                self::SEQUENCE_END => '<',
                self::CONTAINS => '>',
            ],
            ['>', '<'],
        ];

        yield [
            [
                self::SEQUENCE_START => '<style>',
                self::SEQUENCE_END => '</style>',
                self::CONTAINS => 'style',
            ],
            ['<style>', '</style>'],
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => TypeError::class,
                ],
            ],
            [[]],
        ];
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, mixed $element): void
    {
        $this->setExpectException($expected);

        $style = new StyleFrame(...$element);

        self::assertEquals($expected[self::SEQUENCE_START], $style->getSequenceStart());
        self::assertEquals($expected[self::SEQUENCE_END], $style->getSequenceEnd());
        self::assertStringContainsString($expected[self::CONTAINS], $style->getSequenceStart());
    }
}
