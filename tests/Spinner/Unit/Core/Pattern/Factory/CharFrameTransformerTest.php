<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharFrameTransformer;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CharFrameTransformerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $transformer = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameTransformer::class, $transformer);
    }

    public function getTesteeInstance(): ICharFrameTransformer
    {
        return
            new CharFrameTransformer();
    }

    #[Test]
    public function passesFrameOfTargetTypeUnchanged(): void
    {
        $frame = $this->getCharSequenceFrameMock();

        $transformer = $this->getTesteeInstance();

        self::assertSame($frame, $transformer->transform($frame));
    }

    private function getCharSequenceFrameMock(): MockObject&ICharSequenceFrame
    {
        return $this->createMock(ICharSequenceFrame::class);
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
