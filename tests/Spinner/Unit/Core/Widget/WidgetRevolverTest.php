<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $revolver = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolver::class, $revolver);
    }

    public function getTesteeInstance(
        ?IHasStyleSequenceFrame $style = null,
        ?IHasCharSequenceFrame $char = null,
        ?IInterval $interval = null,
    ): IWidgetRevolver {
        return
            new WidgetRevolver(
                style: $style ?? $this->getHasStyleSequenceFrameMock(),
                char: $char ?? $this->getHasCharSequenceFrameMock(),
                interval: $interval ?? $this->getIntervalMock(),
            );
    }

    private function getHasStyleSequenceFrameMock(): MockObject&IHasStyleSequenceFrame
    {
        return $this->createMock(IHasStyleSequenceFrame::class);
    }

    private function getHasCharSequenceFrameMock(): MockObject&IHasCharSequenceFrame
    {
        return $this->createMock(IHasCharSequenceFrame::class);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $revolver = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertSame($interval, $revolver->getInterval());
    }

    #[Test]
    public function canGetFrame(): void
    {
        $dt = 10.0;
        $styleFrame = $this->getStyleSequenceFrameMock();
        $styleFrame
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn('-%s-')
        ;
        $styleFrame
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(2)
        ;
        $charFrame = $this->getCharSequenceFrameMock();
        $charFrame
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn('c')
        ;
        $charFrame
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(1)
        ;

        $style = $this->getHasStyleSequenceFrameMock();
        $style
            ->expects(self::once())
            ->method('getFrame')
            ->with($dt)
            ->willReturn($styleFrame)
        ;

        $char = $this->getHasCharSequenceFrameMock();
        $char
            ->expects(self::once())
            ->method('getFrame')
            ->with($dt)
            ->willReturn($charFrame)
        ;

        $revolver = $this->getTesteeInstance(
            style: $style,
            char: $char,
        );

        $result = $revolver->getFrame($dt);

        self::assertEquals('-c-', $result->getSequence());
        self::assertEquals(3, $result->getWidth());
    }

    private function getStyleSequenceFrameMock(): MockObject&IStyleSequenceFrame
    {
        return $this->createMock(IStyleSequenceFrame::class);
    }

    private function getCharSequenceFrameMock(): MockObject&ICharSequenceFrame
    {
        return $this->createMock(ICharSequenceFrame::class);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }
}
