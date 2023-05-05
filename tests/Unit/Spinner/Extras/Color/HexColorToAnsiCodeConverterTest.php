<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\HexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HexColorToAnsiCodeConverterTest extends TestCaseWithPrebuiltMocksAndStubs
{
    public static function canConvertDataProvider(): iterable
    {
        yield from self::coreTestCanConvertDataProvider();

        foreach (self::simpleCanConvertDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0],
                ],
                [
                    self::ARGUMENTS => [
                        self::COLOR => $item[1],
                        self::STYLE_MODE => $item[2],
                    ],
                ],
            ];
        }
    }

    protected static function coreTestCanConvertDataProvider(): iterable
    {
        $src = SimpleHexColorToAnsiCodeConverterTest::class;
        yield from $src::canConvertDataProvider();
    }

    protected static function simpleCanConvertDataFeeder(): iterable
    {
        $ansi4 = OptionStyleMode::ANSI4;
        $ansi8 = OptionStyleMode::ANSI8;
        $ansi24 = OptionStyleMode::ANSI24;

        yield from [
            // result, color, styleMode
            ['0', '#761176', $ansi4], // color degrading
            ['4', '#00008f', $ansi4], // color degrading
            ['5', '#861185', $ansi4], // color degrading
            ['5', '#d75f87', $ansi4], // color degrading
            ['5', '#d134f2', $ansi4], // color degrading

            ['8;5;238', '#444', $ansi8],
            ['8;5;255', '#eee', $ansi8],
            ['8;5;231', '#fff', $ansi8],
            ['8;5;59', '#434544', $ansi8],
            ['8;5;238', '#454545', $ansi8],
            ['8;5;231', '#fafafa', $ansi8],
            ['8;5;16', '#070707', $ansi8],
        ];
    }

    public static function invalidInputDataProvider(): iterable
    {
        foreach (self::simpleInvalidInputDataFeeder() as $item) {
            yield [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => $item[0],
                        self::MESSAGE => $item[1],
                    ],
                ],
                [
                    self::ARGUMENTS => [
                        self::COLOR => $item[2],
                        self::STYLE_MODE => $item[3],
                    ],
                ],
            ];
        }
    }

    protected static function simpleInvalidInputDataFeeder(): iterable
    {
        $e = InvalidArgumentException::class;
        $none = OptionStyleMode::NONE;
        $ansi4 = OptionStyleMode::ANSI4;
        $ansi8 = OptionStyleMode::ANSI8;
        $ansi24 = OptionStyleMode::ANSI24;

        yield from [
            // exceptionClass, exceptionMessage, color, styleMode
            [$e, 'Unsupported style mode "NONE".', '#000000', $none],
            [$e, 'Invalid color: "#00000".', '#00000', $ansi4],
            [$e, 'Invalid color: "#00000".', '#00000', $ansi8],
            [$e, 'Invalid color: "#00000".', '#00000', $ansi24],
            [$e, 'Empty color string.', '', $ansi24],
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(HexColorToAnsiCodeConverter::class, $converter);
    }

    public function getTesteeInstance(
        ?OptionStyleMode $styleMode = null,
    ): IHexColorToAnsiCodeConverter {
        return new HexColorToAnsiCodeConverter(
            styleMode: $styleMode ?? OptionStyleMode::ANSI24,
        );
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $converter = $this->getTesteeInstance(
            styleMode: $args[self::STYLE_MODE],
        );

        $result = $converter->convert($args[self::COLOR]);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }

    #[Test]
    #[DataProvider('invalidInputDataProvider')]
    public function throwsOnInvalidInput(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $converter = $this->getTesteeInstance(
            styleMode: $args[self::STYLE_MODE],
        );

        $result = $converter->convert($args[self::COLOR]);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }

    #[Test]
    public function throwsIfStyleModeIsNone(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Unsupported style mode "NONE".';

        $test = function (): void {
            $this->getTesteeInstance(styleMode: OptionStyleMode::NONE);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
