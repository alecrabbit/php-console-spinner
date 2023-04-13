<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Render\StyleFrameRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class StyleFrameRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleFrameRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
    }

    public function getTesteeInstance(
        ?IFrameFactory $frameFactory = null,
        ?IStyleRenderer $styleRenderer = null,
        ?OptionStyleMode $styleMode = null,
    ): IStyleFrameRenderer {
        return
            new StyleFrameRenderer(
                frameFactory: $frameFactory ?? $this->getFrameFactoryMock(),
                styleRenderer: $styleRenderer ?? $this->getStyleRendererMock(),
                styleMode: $styleMode ?? OptionStyleMode::NONE,
            );
    }

    #[Test]
    public function canRender(): void
    {
        $frame = $this->getFrameMock();
        $rendered = 'rendered';
        $frameFactory = $this->getFrameFactoryMock();
        $frameFactory
            ->expects(self::once())
            ->method('create')
            ->with($rendered, 0)
            ->willReturn($frame)
        ;
        $styleRenderer = $this->getStyleRendererMock();
        $styleRenderer
            ->expects(self::once())
            ->method('render')
            ->willReturn($rendered)
        ;
        $styleFrameRenderer = $this->getTesteeInstance(
            frameFactory: $frameFactory,
            styleRenderer: $styleRenderer,
            styleMode: OptionStyleMode::ANSI8,
        );
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(false)
        ;
        $style
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(0)
        ;

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
        self::assertSame($frame, $styleFrameRenderer->render($style));
    }

    #[Test]
    public function canRenderIfStyleIsEmpty(): void
    {
        $frame = $this->getFrameMock();
        $format = ' %s ';

        $frameFactory = $this->getFrameFactoryMock();
        $width = 2;
        $frameFactory
            ->expects(self::once())
            ->method('create')
            ->with($format, $width)
            ->willReturn($frame)
        ;
        $styleRenderer = $this->getStyleRendererMock();
        $styleRenderer
            ->expects(self::never())
            ->method('render')
        ;
        $styleFrameRenderer = $this->getTesteeInstance(
            frameFactory: $frameFactory,
            styleRenderer: $styleRenderer,
            styleMode: OptionStyleMode::ANSI8,
        );
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(true)
        ;
        $style
            ->expects(self::once())
            ->method('getFormat')
            ->willReturn($format)
        ;$style
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn($width)
        ;

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
        self::assertSame($frame, $styleFrameRenderer->render($style));
    }

    #[Test]
    public function canRenderIfStyleModeIsNone(): void
    {
        $frameFactory = $this->getFrameFactoryMock();
        $frame = $this->getFrameMock();
        $frameFactory
            ->expects(self::once())
            ->method('create')
            ->with('%s', 0)
            ->willReturn($frame)
        ;
        $styleFrameRenderer = $this->getTesteeInstance(
            frameFactory: $frameFactory,
            styleMode: OptionStyleMode::NONE
        );

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
        self::assertSame($frame, $styleFrameRenderer->render($this->getStyleMock()));
    }
}
