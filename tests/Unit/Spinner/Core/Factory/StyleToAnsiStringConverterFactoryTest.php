<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Color\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Core\Factory\StyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Core\Render\StyleToAnsiStringConverter;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleToAnsiStringConverterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $converterFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleToAnsiStringConverterFactory::class, $converterFactory);
    }

    public function getTesteeInstance(
        ?IAnsiColorParserFactory $parserFactory = null,
        ?IStyleOptionsParser $optionsParser = null,
    ): IStyleToAnsiStringConverterFactory {
        return
            new StyleToAnsiStringConverterFactory(
                parserFactory: $parserFactory ?? $this->getAnsiColorParserFactoryMock(),
                optionsParser: $optionsParser ?? $this->getStyleOptionsParserMock(),
            );
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $styleMode = OptionStyleMode::NONE;
        $colorParser = $this->getAnsiColorParserMock();
        $optionsParser = $this->getStyleOptionsParserMock();
        $parserFactory = $this->getAnsiColorParserFactoryMock();
        $parserFactory
            ->expects(self::once())
            ->method('create')
            ->with($styleMode)
            ->willReturn($colorParser)
        ;

        $converterFactory = $this->getTesteeInstance(
            parserFactory: $parserFactory,
            optionsParser: $optionsParser,
        );

        $stringConverter = $converterFactory->create($styleMode);
        self::assertInstanceOf(StyleToAnsiStringConverterFactory::class, $converterFactory);
        self::assertInstanceOf(StyleToAnsiStringConverter::class, $stringConverter);
        self::assertSame($colorParser, self::getPropertyValue('colorParser', $stringConverter));
        self::assertSame($optionsParser, self::getPropertyValue('optionsParser', $stringConverter));
    }
}
