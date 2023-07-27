<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Core\Revolver\Override\ARevolverOverride;
use PHPUnit\Framework\Attributes\Test;

final class ARevolverTest extends TestCaseWithPrebuiltMocksAndStubs
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
        ?int $deltaTolerance = null,
    ): IRevolver {
        return
            new ARevolverOverride(
                frame: $frame ?? $this->getFrameMock(),
                interval: $interval ?? $this->getIntervalMock(),
                deltaTolerance: $deltaTolerance ?? 0,
            );
    }

    #[Test]
    public function initializedDuringCreate(): void
    {
        $interval = $this->getIntervalMock();
        $value = 10.0;
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn($value)
        ;
        $tolerance = 5;
        $revolver = $this->getTesteeInstance(
            interval: $interval,
            deltaTolerance: $tolerance,
        );

        $intervalValue = self::getPropertyValue('intervalValue', $revolver);
        $deltaTolerance = self::getPropertyValue('deltaTolerance', $revolver);

        self::assertSame($value, $intervalValue);
        self::assertSame($tolerance, $deltaTolerance);
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
            ->method('sequence')
        ;
        $frame
            ->expects(self::once())
            ->method('width')
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

        self::assertSame($frame, $revolver->getFrame(null)); // this calls next()
    }

    #[Test]
    public function canGetFrameInToleranceRange(): void
    {
        $frame = $this->getFrameMock();
        $frame
            ->expects(self::once())
            ->method('sequence')
        ;
        $frame
            ->expects(self::once())
            ->method('width')
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
            deltaTolerance: 10,
        );

        self::assertSame($frame, $revolver->getFrame(90.0)); // this calls next()
        self::assertSame($frame, $revolver->getFrame(80.0)); // this does not call next()
    }

    #[Test]
    public function canGetFrameIfDiffIsBelowZero(): void
    {
        $frame = $this->getFrameMock();
        $frame
            ->expects(self::once())
            ->method('sequence')
        ;
        $frame
            ->expects(self::once())
            ->method('width')
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
            deltaTolerance: 0,
        );

        self::assertSame($frame, $revolver->getFrame(99.0)); // this does not call next()
        self::assertSame($frame, $revolver->getFrame(1.0)); // this calls next()
        self::assertSame($frame, $revolver->getFrame(99.0)); // this does not call next()
    }
}
