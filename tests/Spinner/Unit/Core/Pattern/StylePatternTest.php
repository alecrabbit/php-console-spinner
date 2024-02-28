<?php

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\IStylePattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StylePatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(StylePattern::class, $factory);
    }

    public function getTesteeInstance(
        ?IHasStyleSequenceFrame $frames = null,
        ?IInterval $interval = null,
    ): IStylePattern {
        return new StylePattern(
            frames: $frames ?? $this->getHasStyleSequenceFrameMock(),
            interval: $interval ?? $this->getIntervalMock(),
        );
    }

    private function getHasStyleSequenceFrameMock(): MockObject&IHasStyleSequenceFrame
    {
        return $this->createMock(IHasStyleSequenceFrame::class);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $factory = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertSame($interval, $factory->getInterval());
    }

    #[Test]
    public function canGetFrames(): void
    {
        $f01 = $this->getFrameMock();
        $f02 = $this->getFrameMock();
        $f03 = $this->getFrameMock();

        $frame01 = $this->getStyleSequenceFrameMock();
        $frame02 = $this->getStyleSequenceFrameMock();
        $frame03 = $this->getStyleSequenceFrameMock();

        $frames = $this->getHasStyleSequenceFrameMock();
        $frames
            ->expects(self::exactly(3))
            ->method('getFrame')
            ->willReturnOnConsecutiveCalls(
                $frame01,
                $frame02,
                $frame03,
            )
        ;


        $factory = $this->getTesteeInstance(
            frames: $frames,
        );

        self::assertSame($frame01, $factory->getFrame());
        self::assertSame($frame02, $factory->getFrame());
        self::assertSame($frame03, $factory->getFrame());
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    private function getStyleSequenceFrameMock(): MockObject&IStyleSequenceFrame
    {
        return $this->createMock(IStyleSequenceFrame::class);
    }
}
