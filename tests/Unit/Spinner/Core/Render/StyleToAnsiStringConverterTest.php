<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
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

    public function getTesteeInstance(): IStyleToAnsiStringConverter
    {
        return
            new StyleToAnsiStringConverter(
                converter: $this->getHexColorToAnsiCodeConverterMock(),
            );
    }

    #[Test]
    public function returnsStyleFormatIfStyleIsEmpty(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(StyleToAnsiStringConverter::class, $converter);
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(true)
        ;
        $style
            ->expects(self::once())
            ->method('getFormat')
            ->willReturn('%s')
        ;
        self::assertSame('%s', $converter->convert($style));
    }
}
