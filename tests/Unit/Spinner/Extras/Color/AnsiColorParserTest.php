<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\AnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class AnsiColorParserTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $colorParser = $this->getTesteeInstance();

        self::assertInstanceOf(AnsiColorParser::class, $colorParser);
    }

    protected function getTesteeInstance(
        ?IHexColorToAnsiCodeConverter $converter = null,
    ): IAnsiColorParser {
        return new AnsiColorParser(
            converter: $converter ?? $this->getHexColorToAnsiCodeConverterMock(),
        );
    }

    #[Test]
    public function invokesAnsiConvertMethodIfColorFormatIsOk(): void
    {
        $converter = $this->getHexColorToAnsiCodeConverterMock();
        $color = '#ffaacc';
        $result = 'result';
        $converter
            ->expects(self::once())
            ->method('convert')
            ->with(self::equalTo($color))
            ->willReturn($result)
        ;
        $colorParser = $this->getTesteeInstance(converter: $converter);

        self::assertSame($result, $colorParser->parseColor($color));
    }

    #[Test]
    public function throwsIfInvalidColorFormatProvided(): void
    {
        $colorParser = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid color format: "ffaacc".');

        $colorParser->parseColor('ffaacc');
    }

    #[Test]
    public function emptyColorReturnsEmptyParsedString(): void
    {
        $colorParser = $this->getTesteeInstance();

        self::assertSame('', $colorParser->parseColor(''));
    }
}
