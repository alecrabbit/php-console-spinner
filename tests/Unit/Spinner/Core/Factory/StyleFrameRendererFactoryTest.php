<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRendererFactory;
use AlecRabbit\Spinner\Core\Render\StyleFrameRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleFrameRendererFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleFrameRendererFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRendererFactory::class, $styleFrameRendererFactory);
    }

    public function getTesteeInstance(
        ?IFrameFactory $frameFactory = null,
        ?IStyleRendererFactory $styleRendererFactory = null,
        ?OptionStyleMode $styleMode = null,
    ): IStyleFrameRendererFactory {
        return new StyleFrameRendererFactory(
            frameFactory: $frameFactory ?? $this->getFrameFactoryMock(),
            styleRendererFactory: $styleRendererFactory ?? $this->getStyleRendererFactoryMock(),
            styleMode: $styleMode ?? OptionStyleMode::ANSI4,
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $styleMode = OptionStyleMode::ANSI4; // lowest
        $frameFactory = $this->getFrameFactoryMock();
        $styleRenderer = $this->getStyleRendererMock();

        $styleRendererFactory = $this->getStyleRendererFactoryMock();
        $styleRendererFactory
            ->expects(self::once())
            ->method('create')
            ->with($styleMode)
            ->willReturn($styleRenderer)
        ;

        $styleFrameRendererFactory = $this->getTesteeInstance(
            frameFactory: $frameFactory,
            styleRendererFactory: $styleRendererFactory,
            styleMode: OptionStyleMode::ANSI24 // to use lowest
        );

        $renderer = $styleFrameRendererFactory->create($styleMode);
        self::assertInstanceOf(StyleFrameRendererFactory::class, $styleFrameRendererFactory);
        self::assertInstanceOf(StyleFrameRenderer::class, $renderer);

        self::assertSame($frameFactory, self::getPropertyValue('frameFactory', $renderer));
        self::assertSame($styleRenderer, self::getPropertyValue('styleRenderer', $renderer));
        self::assertSame($styleMode, self::getPropertyValue('styleMode', $renderer));
    }
}