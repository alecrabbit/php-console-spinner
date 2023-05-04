<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\StyleRendererFactory;
use AlecRabbit\Spinner\Extras\Render\StyleRenderer;
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
        return new StyleRendererFactory(
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
            ->willReturn($converter)
        ;

        $styleRendererFactory = $this->getTesteeInstance(converterFactory: $converterFactory);

        $renderer = $styleRendererFactory->create($styleMode);
        self::assertInstanceOf(StyleRendererFactory::class, $styleRendererFactory);
        self::assertInstanceOf(StyleRenderer::class, $renderer);
        self::assertSame($converter, self::getPropertyValue('converter', $renderer));
    }
}
