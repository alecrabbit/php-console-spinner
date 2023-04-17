<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;


use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\HexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Core\Factory\StyleRendererFactory;
use AlecRabbit\Spinner\Core\Render\StyleRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleRendererFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleRendererFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleRendererFactory::class, $styleRendererFactory);
    }

    public function getTesteeInstance(
        ?IStyleToAnsiStringConverterFactory $converterFactory = null,
    ): IStyleRendererFactory {
        return
            new StyleRendererFactory(
                converterFactory: $converterFactory ?? $this->getStyleToAnsiStringConverterFactoryMock(),
            );
    }

    #[Test]
    public function canCreate(): void
    {
        $styleMode = OptionStyleMode::ANSI4;
        $converter = $this->getStyleToAnsiStringConverterMock();

        $converterFactory = $this->getStyleToAnsiStringConverterFactoryMock();
        $converterFactory
            ->expects(self::once())
            ->method('create')
            ->with($styleMode)
            ->willReturn($converter);

        $styleRendererFactory = $this->getTesteeInstance(converterFactory: $converterFactory);

        $renderer = $styleRendererFactory->create($styleMode);
        self::assertInstanceOf(StyleRendererFactory::class, $styleRendererFactory);
        self::assertInstanceOf(StyleRenderer::class, $renderer);
        self::assertSame($converter, self::getPropertyValue('converter', $renderer));
    }
}
