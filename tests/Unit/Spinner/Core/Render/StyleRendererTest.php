<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Render\StyleRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class StyleRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleFrameRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleRenderer::class, $styleFrameRenderer);
    }

    public function getTesteeInstance(): IStyleRenderer
    {
        return
            new StyleRenderer();
    }

    #[Test]
    public function canRenderIfStyleModeIsNone(): void
    {
        $styleFrameRenderer = $this->getTesteeInstance();
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(false)
        ;
        $style
            ->expects(self::once())
            ->method('getFormat')
            ->willReturn('%s ')
        ;
        $style
            ->expects(self::never())
            ->method('getWidth')
        ;

        self::assertInstanceOf(StyleRenderer::class, $styleFrameRenderer);
        self::assertEquals(
            '%s ',
            $styleFrameRenderer->render($style, OptionStyleMode::NONE),
        );
    }

    #[Test]
    public function canRender(): void
    {
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(false)
        ;
        $style
            ->expects(self::once())
            ->method('getFormat')
            ->willReturn('%s ')
        ;
        $style
            ->expects(self::never())
            ->method('getWidth')
        ;
        $styleFrameRenderer = $this->getTesteeInstance();
        self::assertInstanceOf(StyleRenderer::class, $styleFrameRenderer);
        self::assertEquals(
            '%s ', // FIXME (2023-04-13 15:57) [Alec Rabbit]: its not correct
            $styleFrameRenderer->render($style, OptionStyleMode::ANSI8),
        );
    }

    #[Test]
    public function throwsIfStyleIsEmpty(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Style is empty.';

        $test = function () {
            $style = $this->getStyleMock();
            $style
                ->expects(self::once())
                ->method('isEmpty')
                ->willReturn(true)
            ;
            $this->getTesteeInstance()->render($style, OptionStyleMode::ANSI8);
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
        );
    }
}
