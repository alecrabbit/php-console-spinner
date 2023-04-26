<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\AnsiColorParser;
use AlecRabbit\Spinner\Core\Factory\AnsiColorParserFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class AnsiColorParserFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $parserFactory = $this->getTesteeInstance();

        self::assertInstanceOf(AnsiColorParserFactory::class, $parserFactory);
    }

    public function getTesteeInstance(
        ?IHexColorToAnsiCodeConverterFactory $converterFactory = null,
    ): IAnsiColorParserFactory {
        return new AnsiColorParserFactory(
            converterFactory: $converterFactory ?? $this->getHexColorToAnsiCodeConverterFactoryMock(),
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $parserFactory = $this->getTesteeInstance();

        self::assertInstanceOf(AnsiColorParserFactory::class, $parserFactory);
        self::assertInstanceOf(
            AnsiColorParser::class,
            $parserFactory->create(OptionStyleMode::ANSI8)
        );
    }
}
