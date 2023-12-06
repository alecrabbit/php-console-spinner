<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widget = $this->getTesteeInstance();

        self::assertInstanceOf(Widget::class, $widget);
    }

    public function getTesteeInstance(
        ?IWidgetRevolver $revolver = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IObserver $observer = null,
    ): IWidget {
        return
            new Widget(
                widgetRevolver: $revolver ?? $this->getWidgetRevolverMock(),
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                observer: $observer ?? $this->getObserverMock(),
            );
    }

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $revolver = $this->getWidgetRevolverMock();

        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $widget = $this->getTesteeInstance(
            revolver: $revolver,
        );

        self::assertSame($interval, $widget->getInterval());
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canGetFrameIfHasRevolverOnly(): void
    {
        $revolverFrame = $this->getFrameMock();
        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getFrame')
            ->willReturn($revolverFrame)
        ;

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $widget = $this->getTesteeInstance(
            revolver: $revolver,
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
        );

        $revolverFrame
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn('rfs')
        ;
        $revolverFrame
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(3)
        ;

        $leadingSpacer
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn('ls')
        ;
        $leadingSpacer
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(2)
        ;

        $trailingSpacer
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn('ts')
        ;
        $trailingSpacer
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(2)
        ;

        $result = $widget->getFrame();

        self::assertSame('lsrfsts', $result->getSequence());
        self::assertSame(7, $result->getWidth());
    }
}
