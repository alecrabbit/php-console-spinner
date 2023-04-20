<?php

declare(strict_types=1);

// 03.04.23

namespace AlecRabbit\Tests\Unit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\RGBColor;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Render\StyleFrameCollectionRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class StyleFrameCollectionRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $collectionRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameCollectionRenderer::class, $collectionRenderer);
    }

    public function getTesteeInstance(
        ?IStyleFrameRendererFactory $styleFrameRendererFactory = null,
        ?IStyleFactory $styleFactory = null,
        ?OptionStyleMode $styleMode = null,
    ): IStyleFrameCollectionRenderer {
        return new StyleFrameCollectionRenderer(
            styleFrameRendererFactory: $styleFrameRendererFactory ?? $this->getStyleFrameRendererFactoryMock(),
            styleFactory: $styleFactory ?? $this->getStyleFactoryMock(),
            styleMode: $styleMode ?? OptionStyleMode::NONE,
        );
    }

    #[Test]
    public function canRender(): void
    {
        $styleMode = OptionStyleMode::ANSI8;

        $frame = $this->getFrameMock();
        $styleFrameRendererFactory = $this->getStyleFrameRendererFactoryMock();
        $styleFrameRenderer = $this->getStyleFrameRendererMock();
        $styleFrameRenderer
            ->expects(self::once())
            ->method('render')
            ->willReturn($frame)
        ;
        $styleFrameRendererFactory
            ->expects(self::once())
            ->method('create')
            ->with($styleMode)
            ->willReturn($styleFrameRenderer)
        ;
        $styleFactory = $this->getStyleFactoryMock();
        $styleFactory
            ->expects(self::never())
            ->method('fromString')
        ;

        $collectionRenderer = $this->getTesteeInstance(
            styleFrameRendererFactory:  $styleFrameRendererFactory,
            styleFactory: $styleFactory,
            styleMode: $styleMode,
        );

        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::once())
            ->method('getStyleMode')
            ->willReturn($styleMode)
        ;
        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(new ArrayObject([$this->getStyleMock()]))
        ;
        $collection = $collectionRenderer->render($pattern);
        self::assertInstanceOf(FrameCollection::class, $collection);
        self::assertSame($frame, $collection[0]);
    }

    #[Test]
    public function canRenderFromString(): void
    {
        $styleMode = OptionStyleMode::ANSI8;

        $frame = $this->getFrameMock();
        $styleFrameRendererFactory = $this->getStyleFrameRendererFactoryMock();
        $styleFrameRenderer = $this->getStyleFrameRendererMock();
        $styleFrameRenderer
            ->expects(self::once())
            ->method('render')
            ->willReturn($frame)
        ;
        $styleFrameRendererFactory
            ->expects(self::once())
            ->method('create')
            ->with($styleMode)
            ->willReturn($styleFrameRenderer)
        ;
        $styleFactory = $this->getStyleFactoryMock();
        $styleFactory
            ->expects(self::once())
            ->method('fromString')
        ;

        $collectionRenderer = $this->getTesteeInstance(
            styleFrameRendererFactory:  $styleFrameRendererFactory,
            styleFactory: $styleFactory,
            styleMode: $styleMode,
        );

        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::once())
            ->method('getStyleMode')
            ->willReturn($styleMode)
        ;
        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(new ArrayObject(['#ffffff']))
        ;
        $collection = $collectionRenderer->render($pattern);
        self::assertInstanceOf(FrameCollection::class, $collection);
        self::assertSame($frame, $collection[0]);
    }

    #[Test]
    public function canRenderFromFrame(): void
    {
        $styleMode = OptionStyleMode::ANSI8;

        $frame = $this->getFrameMock();
        $styleFrameRendererFactory = $this->getStyleFrameRendererFactoryMock();
        $styleFrameRenderer = $this->getStyleFrameRendererMock();
        $styleFrameRenderer
            ->expects(self::never())
            ->method('render')
        ;
        $styleFrameRendererFactory
            ->expects(self::once())
            ->method('create')
            ->with($styleMode)
            ->willReturn($styleFrameRenderer)
        ;
        $styleFactory = $this->getStyleFactoryMock();
        $styleFactory
            ->expects(self::never())
            ->method('fromString')
        ;

        $collectionRenderer = $this->getTesteeInstance(
            styleFrameRendererFactory:  $styleFrameRendererFactory,
            styleFactory: $styleFactory,
            styleMode: $styleMode,
        );

        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::once())
            ->method('getStyleMode')
            ->willReturn($styleMode)
        ;
        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(new ArrayObject([$frame]))
        ;
        $collection = $collectionRenderer->render($pattern);
        self::assertInstanceOf(FrameCollection::class, $collection);
        self::assertSame($frame, $collection[0]);
    }

    #[Test]
    public function canRenderFromStringable(): void
    {
        $styleMode = OptionStyleMode::ANSI8;

        $frame = $this->getFrameMock();
        $styleFrameRendererFactory = $this->getStyleFrameRendererFactoryMock();
        $styleFrameRenderer = $this->getStyleFrameRendererMock();
        $styleFrameRenderer
            ->expects(self::once())
            ->method('render')
            ->willReturn($frame)
        ;
        $styleFrameRendererFactory
            ->expects(self::once())
            ->method('create')
            ->with($styleMode)
            ->willReturn($styleFrameRenderer)
        ;
        $styleFactory = $this->getStyleFactoryMock();
        $styleFactory
            ->expects(self::once())
            ->method('fromString')
        ;

        $collectionRenderer = $this->getTesteeInstance(
            styleFrameRendererFactory:  $styleFrameRendererFactory,
            styleFactory: $styleFactory,
            styleMode: $styleMode,
        );

        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::once())
            ->method('getStyleMode')
            ->willReturn($styleMode)
        ;
        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(new ArrayObject([RGBColor::fromHex('#ffffff')]))
        ;
        $collection = $collectionRenderer->render($pattern);
        self::assertInstanceOf(FrameCollection::class, $collection);
        self::assertSame($frame, $collection[0]);
    }
}
