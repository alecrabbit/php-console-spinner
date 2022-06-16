<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Style;
use AlecRabbit\Tests\Spinner\TestCase;

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
                self::SEQUENCE => '%s',
                self::CONTAINS => C::STR_PLACEHOLDER,
            ],
            null,
        ];

        yield [
            [
                self::SEQUENCE => '<style>%s</style>',
                self::CONTAINS => C::STR_PLACEHOLDER,
            ],
            '<style>%s</style>',
        ];

        yield [
            [
                self::SEQUENCE => ($style = Style::create(self::STYLE))->sequence,
                self::CONTAINS => C::STR_PLACEHOLDER,
            ],
            $style,
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::_CLASS => InvalidArgumentException::class,
                    self::MESSAGE => 'Unsupported style element: [array].',
                ],
            ],
            [],
        ];
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, mixed $element): void
    {
        $this->checkForExceptionExpectance($expected);

        $style = Style::create($element);

        self::assertEquals($expected[self::SEQUENCE], $style->sequence);
        self::assertStringContainsString($expected[self::CONTAINS], $style->sequence);
    }
}
