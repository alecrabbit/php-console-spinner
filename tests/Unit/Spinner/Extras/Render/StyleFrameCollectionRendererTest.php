<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Extras\Color\RGBColor;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleFrameCollectionRenderer;
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
    ): IStyleFrameCollectionRenderer {
        return new StyleFrameCollectionRenderer(
            styleFrameRendererFactory: $styleFrameRendererFactory ?? $this->getStyleFrameRendererFactoryMock(),
            styleFactory: $styleFactory ?? $this->getStyleFactoryMock(),
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
            ->expects(self::never())
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
            styleFrameRendererFactory: $styleFrameRendererFactory,
            styleFactory: $styleFactory,
        );

        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::exactly(2))
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
            styleFrameRendererFactory: $styleFrameRendererFactory,
            styleFactory: $styleFactory,
        );

        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::exactly(2))
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
            styleFrameRendererFactory: $styleFrameRendererFactory,
            styleFactory: $styleFactory,
        );

        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::exactly(2))
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
            styleFrameRendererFactory: $styleFrameRendererFactory,
            styleFactory: $styleFactory,
        );

        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::exactly(2))
            ->method('getStyleMode')
            ->willReturn($styleMode)
        ;
        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(new ArrayObject([RGBColor::fromString('#ffffff')]))
        ;
        $collection = $collectionRenderer->render($pattern);
        self::assertInstanceOf(FrameCollection::class, $collection);
        self::assertSame($frame, $collection[0]);
    }
}
