<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Tests\Spinner\Unit\Core\Revolver\Override\ARevolverOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ARevolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $revolver = $this->getTesteeInstance();

        self::assertInstanceOf(ARevolverOverride::class, $revolver);
    }

    public function getTesteeInstance(
        ?IFrame $frame = null,
        ?IInterval $interval = null,
        ?ITolerance $tolerance = null,
    ): IRevolver {
        return
            new ARevolverOverride(
                frame: $frame ?? $this->getFrameMock(),
                interval: $interval ?? $this->getIntervalMock(),
                tolerance: $tolerance ?? $this->getToleranceMock(),
            );
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    #[Test]
    public function initializedDuringCreate(): void
    {
        $intervalValue = 10.0;
        $deltaTolerance = 5;

        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn($intervalValue)
        ;
        $tolerance = $this->getToleranceMock();
        $tolerance
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn($deltaTolerance)
        ;

        $revolver = $this->getTesteeInstance(
            interval: $interval,
            tolerance: $tolerance,
        );

        $extractedIntervalValue = self::getPropertyValue('intervalValue', $revolver);
        $extractedDeltaTolerance = self::getPropertyValue('deltaTolerance', $revolver);

        self::assertSame($intervalValue, $extractedIntervalValue);
        self::assertSame($deltaTolerance, $extractedDeltaTolerance);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $revolver = $this->getTesteeInstance(interval: $interval);
        self::assertSame($interval, $revolver->getInterval());
    }

    #[Test]
    public function canGetFrame(): void
    {
        $frame = $this->getFrameMock();
        $frame
            ->expects(self::once())
            ->method('getSequence')
        ;
        $frame
            ->expects(self::once())
            ->method('getWidth')
        ;
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(100.0)
        ;

        $revolver = $this->getTesteeInstance(
            frame: $frame,
            interval: $interval,
        );

        self::assertSame($frame, $revolver->getFrame()); // no arg is for calling next()
    }

    #[Test]
    public function canGetFrameInToleranceRange(): void
    {
        $frame = $this->getFrameMock();
        $frame
            ->expects(self::once())
            ->method('getSequence')
        ;
        $frame
            ->expects(self::once())
            ->method('getWidth')
        ;
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(100.0)
        ;
        $tolerance = $this->getToleranceMock();
        $tolerance
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(10)
        ;

        $revolver = $this->getTesteeInstance(
            frame: $frame,
            interval: $interval,
            tolerance: $tolerance,
        );

        self::assertSame($frame, $revolver->getFrame(90.0)); // calls `next()`
        self::assertSame($frame, $revolver->getFrame(80.0)); // does not call `next()`
    }

    #[Test]
    public function canGetFrameIfDiffIsBelowZero(): void
    {
        $frame = $this->getFrameMock();
        $frame
            ->expects(self::once())
            ->method('getSequence')
        ;
        $frame
            ->expects(self::once())
            ->method('getWidth')
        ;
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(100.0)
        ;
        $tolerance = $this->getToleranceMock();
        $tolerance
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(0)
        ;

        $revolver = $this->getTesteeInstance(
            frame: $frame,
            interval: $interval,
            tolerance: $tolerance,
        );

        self::assertSame($frame, $revolver->getFrame(99.0)); // does not call `next()`
        self::assertSame($frame, $revolver->getFrame(1.0)); // calls `next()`
        self::assertSame($frame, $revolver->getFrame(99.0)); // does not call `next()`
    }
}
