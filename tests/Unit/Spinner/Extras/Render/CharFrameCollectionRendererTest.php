<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Extras\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\CharFrameCollectionRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class CharFrameCollectionRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $collectionRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameCollectionRenderer::class, $collectionRenderer);
    }

    public function getTesteeInstance(
        ?ICharFrameRenderer $frameRenderer = null,
    ): ICharFrameCollectionRenderer {
        return new CharFrameCollectionRenderer(
            frameRenderer: $frameRenderer ?? $this->getCharFrameRendererMock(),
        );
    }

    #[Test]
    public function canRender(): void
    {
        $str = '1';
        $width = 1;

        $frameRenderer = $this->getCharFrameRendererMock();
        $frameMock = $this->getFrameMock();
        $frameMock
            ->expects(self::once())
            ->method('sequence')
            ->willReturn($str)
        ;
        $frameMock
            ->expects(self::once())
            ->method('width')
            ->willReturn($width)
        ;

        $frameRenderer
            ->expects(self::once())
            ->method('render')
            ->willReturn($frameMock)
        ;

        $collectionRenderer = $this->getTesteeInstance(frameRenderer: $frameRenderer);

        $pattern = $this->getCharPatternMock();

        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(new ArrayObject([$str]))
        ;
        $collection = $collectionRenderer->render($pattern);
        self::assertInstanceOf(FrameCollection::class, $collection);
        $frame = $collection[0];
        self::assertSame($str, $frame->sequence());
        self::assertSame($width, $frame->width());
    }

    #[Test]
    public function canRenderFromFrame(): void
    {
        $str = '1';
        $width = 1;

        $frameRenderer = $this->getCharFrameRendererMock();
        $frameRenderer
            ->expects(self::never())
            ->method('render')
        ;
        $frameMock = $this->getFrameMock();
        $frameMock
            ->expects(self::once())
            ->method('sequence')
            ->willReturn($str)
        ;
        $frameMock
            ->expects(self::once())
            ->method('width')
            ->willReturn($width)
        ;

        $collectionRenderer = $this->getTesteeInstance(frameRenderer: $frameRenderer);

        $pattern = $this->getCharPatternMock();

        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(new ArrayObject([$frameMock]))
        ;
        $collection = $collectionRenderer->render($pattern);
        self::assertInstanceOf(FrameCollection::class, $collection);
        $frame = $collection[0];
        self::assertSame($str, $frame->sequence());
        self::assertSame($width, $frame->width());
    }

    #[Test]
    public function canRenderFromStringable(): void
    {
        $str = '1';
        $width = 1;

        $frameRenderer = $this->getCharFrameRendererMock();

        $frameMock = $this->getFrameMock();
        $frameMock
            ->expects(self::once())
            ->method('sequence')
            ->willReturn($str)
        ;
        $frameMock
            ->expects(self::once())
            ->method('width')
            ->willReturn($width)
        ;
        $frameRenderer
            ->expects(self::once())
            ->method('render')
            ->willReturn($frameMock)
        ;
        $collectionRenderer = $this->getTesteeInstance(frameRenderer: $frameRenderer);

        $pattern = $this->getCharPatternMock();

        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(
                new ArrayObject([
                    new class($str) {
                        public function __construct(private readonly string $str)
                        {
                        }

                        public function __toString(): string
                        {
                            return $this->str;
                        }
                    },
                ])
            )
        ;
        $collection = $collectionRenderer->render($pattern);
        self::assertInstanceOf(FrameCollection::class, $collection);
        $frame = $collection[0];
        self::assertSame($str, $frame->sequence());
        self::assertSame($width, $frame->width());
    }
}
