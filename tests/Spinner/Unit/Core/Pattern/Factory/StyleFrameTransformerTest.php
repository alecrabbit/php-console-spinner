<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\StyleFrameTransformer;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StyleFrameTransformerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $transformer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameTransformer::class, $transformer);
    }

    public function getTesteeInstance(): IStyleFrameTransformer
    {
        return
            new StyleFrameTransformer();
    }

    #[Test]
    public function passesFrameOfTargetTypeUnchanged(): void
    {
        $frame = $this->getStyleSequenceFrameMock();

        $transformer = $this->getTesteeInstance();

        self::assertSame($frame, $transformer->transform($frame));
    }

    private function getStyleSequenceFrameMock(): MockObject&IStyleSequenceFrame
    {
        return $this->createMock(IStyleSequenceFrame::class);
    }

    #[Test]
    public function throwsIfFrameTypeIsNonTransformable(): void
    {
        $frame = $this->getFrameMock();

        $transformer = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Non-transformable frame type "%s".',
                get_class($frame),
            )
        );

        $transformer->transform($frame);
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }
}
