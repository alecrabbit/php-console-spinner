<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Extras\Color\Style\StyleOptions;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Extras\Contract\Style\StyleOption;
use AlecRabbit\Spinner\Extras\StyleToAnsiStringConverter;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleToAnsiStringConverterTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(StyleToAnsiStringConverter::class, $converter);
    }

    public function getTesteeInstance(
        ?IAnsiColorParser $colorParser = null,
        ?IStyleOptionsParser $optionsParser = null,
    ): IStyleToAnsiStringConverter {
        return new StyleToAnsiStringConverter(
            colorParser: $colorParser ?? $this->getAnsiColorParserMock(),
            optionsParser: $optionsParser ?? $this->getStyleOptionsParserMock(),
        );
    }

    #[Test]
    public function convertReturnsStyleFormatIfStyleIsEmpty(): void
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

    #[Test]
    public function convertReturnsFormatIfStyleIsNotEmpty(): void
    {
        $red = '#ff0000';
        $green = '#00ff00';

        $colorParser = $this->getAnsiColorParserMock();
        $colorParser
            ->method('parseColor')
            ->willReturn('1')
        ;
        $optionsParser = $this->getStyleOptionsParserMock();
        $optionsParser
            ->method('parseOptions')
            ->willReturn([['set' => 1, 'unset' => 22]])
        ;
        $converter = $this->getTesteeInstance(
            colorParser: $colorParser,
            optionsParser: $optionsParser,
        );

        self::assertInstanceOf(StyleToAnsiStringConverter::class, $converter);
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(false)
        ;
        $style
            ->expects(self::once())
            ->method('getFgColor')
            ->willReturn($red)
        ;
        $style
            ->expects(self::once())
            ->method('getBgColor')
            ->willReturn($green)
        ;
        $style
            ->expects(self::once())
            ->method('hasOptions')
            ->willReturn(true)
        ;
        $style
            ->expects(self::once())
            ->method('getOptions')
            ->willReturn(new StyleOptions(StyleOption::BOLD))
        ;
        $style
            ->expects(self::once())
            ->method('getFormat')
            ->willReturn('%s')
        ;
        self::assertSame("\e[31;41;1m%s\e[39;49;22m", $converter->convert($style));
    }

    #[Test]
    public function convertReturnsFormatIfStyleIsNotEmptyButNoOptions(): void
    {
        $red = '#ff0000';
        $green = '#00ff00';

        $colorParser = $this->getAnsiColorParserMock();
        $colorParser
            ->method('parseColor')
            ->willReturn('1')
        ;
        $optionsParser = $this->getStyleOptionsParserMock();
        $optionsParser
            ->method('parseOptions')
            ->willReturn([['set' => 1, 'unset' => 22]])
        ;
        $converter = $this->getTesteeInstance(
            colorParser: $colorParser,
            optionsParser: $optionsParser,
        );

        self::assertInstanceOf(StyleToAnsiStringConverter::class, $converter);
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(false)
        ;
        $style
            ->expects(self::once())
            ->method('getFgColor')
            ->willReturn($red)
        ;
        $style
            ->expects(self::once())
            ->method('getBgColor')
            ->willReturn($green)
        ;
        $style
            ->expects(self::once())
            ->method('hasOptions')
            ->willReturn(false)
        ;
        $style
            ->expects(self::never())
            ->method('getOptions')
        ;
        $style
            ->expects(self::once())
            ->method('getFormat')
            ->willReturn('%s')
        ;
        self::assertSame("\e[31;41m%s\e[39;49m", $converter->convert($style));
    }
}
