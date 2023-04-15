<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Render;

use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Core\Render\StyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsiColorParser;
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
        ?IAnsiColorParser $parser = null,
    ): IStyleToAnsiStringConverter {
        return
            new StyleToAnsiStringConverter(
                parser: $parser ?? $this->getAnsiColorParserMock(),
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
