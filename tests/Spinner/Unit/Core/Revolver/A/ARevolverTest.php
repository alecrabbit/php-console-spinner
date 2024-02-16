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
    ): IRevolver {
        return
            new ARevolverOverride(
                frame: $frame ?? $this->getFrameMock(),
                interval: $interval ?? $this->getIntervalMock(),
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

        $revolver = $this->getTesteeInstance(
            frame: $frame,
        );

        self::assertSame($frame, $revolver->getFrame()); // no arg is for calling next()
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }
}
