<?php

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\ICharPattern;
use AlecRabbit\Spinner\Core\Pattern\CharPattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CharPatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();

        self::assertInstanceOf(CharPattern::class, $pattern);
    }

    public function getTesteeInstance(
        ?IHasCharSequenceFrame $frames = null,
        ?IInterval $interval = null,
    ): ICharPattern {
        return new CharPattern(
            frames: $frames ?? $this->getHasCharSequenceFrameMock(),
            interval: $interval ?? $this->getIntervalMock(),
        );
    }

    private function getHasCharSequenceFrameMock(): MockObject&IHasCharSequenceFrame
    {
        return $this->createMock(IHasCharSequenceFrame::class);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getCharFrameTransformerMock(): MockObject&ICharFrameTransformer
    {
        return $this->createMock(ICharFrameTransformer::class);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $pattern = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertSame($interval, $pattern->getInterval());
    }

    #[Test]
    public function canGetFrames(): void
    {
        $frame01 = $this->getCharSequenceFrameMock();
        $frame02 = $this->getCharSequenceFrameMock();
        $frame03 = $this->getCharSequenceFrameMock();

        $frames = $this->getHasCharSequenceFrameMock();
        $frames
            ->expects(self::exactly(3))
            ->method('getFrame')
            ->willReturnOnConsecutiveCalls(
                $frame01,
                $frame02,
                $frame03,
            )
        ;

        $pattern = $this->getTesteeInstance(
            frames: $frames,
        );

        self::assertSame($frame01, $pattern->getFrame());
        self::assertSame($frame02, $pattern->getFrame());
        self::assertSame($frame03, $pattern->getFrame());
    }

    private function getCharSequenceFrameMock(): MockObject&ICharSequenceFrame
    {
        return $this->createMock(ICharSequenceFrame::class);
    }
}
