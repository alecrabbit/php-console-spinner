<?php

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\INeoStylePattern;
use AlecRabbit\Spinner\Core\Pattern\NeoStylePattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NeoStylePatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(NeoStylePattern::class, $factory);
    }

    public function getTesteeInstance(
        ?IHasFrame $frames = null,
        ?IInterval $interval = null,
    ): INeoStylePattern {
        return new NeoStylePattern(
            frames: $frames ?? $this->getHasFrameMock(),
            interval: $interval ?? $this->getIntervalMock(),
        );
    }

    private function getHasFrameMock(): MockObject&IHasFrame
    {
        return $this->createMock(IHasFrame::class);
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
        $frame01 = $this->getStyleSequenceFrameMock();
        $frame02 = $this->getStyleSequenceFrameMock();
        $frame03 = $this->getStyleSequenceFrameMock();

        $frames = $this->getHasFrameMock();
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

    private function getStyleSequenceFrameMock(): MockObject&IStyleSequenceFrame
    {
        return $this->createMock(IStyleSequenceFrame::class);
    }
}
