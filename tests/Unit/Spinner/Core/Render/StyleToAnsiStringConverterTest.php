<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Output\ISequencer;
use AlecRabbit\Spinner\Core\Color\Style\Style;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Core\Render\StyleToAnsiStringConverter;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class StyleToAnsiStringConverterTest extends TestCaseWithPrebuiltMocksAndStubs
{
    public static function canConvertDataProvider(): iterable
    {
        foreach (self::simpleCanConvertDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0],
                ],
                [
                    self::ARGUMENTS => [
                        self::STYLE => $item[1],
                        self::STYLE_MODE => $item[2],
                    ],
                ],
            ];
        }
    }

    protected static function simpleCanConvertDataFeeder(): iterable
    {
        yield from [
            // result, style, styleMode
            ['31m%s', new Style(fgColor: '#800000'), OptionStyleMode::ANSI4],
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(StyleToAnsiStringConverter::class, $converter);
    }

    public function getTesteeInstance(
        ?OptionStyleMode $styleMode = null,
        ?ISequencer $sequencer = null,
    ): IStyleToAnsiStringConverter {
        return
            new StyleToAnsiStringConverter(
                styleMode: $styleMode ?? OptionStyleMode::NONE,
                sequencer: $sequencer ?? $this->getSequencerMock(),
            );
    }

    #[Test]
    public function returnsStyleFormatIfStyleIsEmpty(): void
    {
        $converter = $this->getTesteeInstance(
            styleMode: OptionStyleMode::ANSI24,
        );

        self::assertInstanceOf(StyleToAnsiStringConverter::class, $converter);
        $style = new Style();
        self::assertTrue($style->isEmpty());
        self::assertSame($style->getFormat(), $converter->convert($style),);
    }

    #[Test]
    public function returnsStyleFormatIfStyleIsNotEmptyButStyleModeIsNone(): void
    {
        $converter = $this->getTesteeInstance(
            styleMode: OptionStyleMode::NONE,
        );

        self::assertInstanceOf(StyleToAnsiStringConverter::class, $converter);
        $style = new Style(fgColor: 'red');
        self::assertFalse($style->isEmpty());
        self::assertSame($style->getFormat(), $converter->convert($style),);
    }

//    #[Test]
//    #[DataProvider('canConvertDataProvider')]
//    public function canConvert(array $expected, array $incoming): void
//    {
//        $expectedException = $this->expectsException($expected);
//
//        $args = $incoming[self::ARGUMENTS];
//
//        $converter = $this->getTesteeInstance(
//            styleMode: $args[self::STYLE_MODE] ?? OptionStyleMode::NONE,
//        );
//
//        $result = $converter->convert($args[self::STYLE]);
//
//        if ($expectedException) {
//            self::failTest($expectedException);
//        }
//
//        self::assertSame($expected[self::RESULT], $result);
//    }

//    #[Test]
//    public function throwsIfStyleIsEmpty(): void
//    {
//        $exceptionClass = InvalidArgumentException::class;
//        $exceptionMessage = 'Style is empty.';
//
//        $test = function () {
//            $style = $this->getStyleMock();
//            $style
//                ->expects(self::once())
//                ->method('isEmpty')
//                ->willReturn(true)
//            ;
//            $this->getTesteeInstance()->render($style) ;
//        };
//
//        $this->testExceptionWrapper(
//            exceptionClass: $exceptionClass,
//            exceptionMessage: $exceptionMessage,
//            test: $test,
//        );
//    }
}
