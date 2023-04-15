<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Core\Color\AnsiColorParser;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
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
        return
            new AnsiColorParser(
                converter: $converter ?? $this->getHexColorToAnsiCodeConverterMock(),
            );
    }

    #[Test]
    public function invokesAnsiConvertMethodIfColorFormatIsRecognised(): void
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

        self::assertSame($result, $colorParser->parse($color));
    }

    #[Test]
    public function throwsIfInvalidColorFormatProvided(): void
    {
        $colorParser = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid color format: "ffaacc".');

        $colorParser->parse('ffaacc');
    }

    #[Test]
    public function emptyColorReturnsEmptyParsedString(): void
    {
        $colorParser = $this->getTesteeInstance();

        self::assertSame('', $colorParser->parse(''));
    }
}
