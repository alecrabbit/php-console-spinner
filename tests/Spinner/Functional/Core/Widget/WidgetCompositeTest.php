<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntervalComparator;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Extras\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Extras\Widget\WidgetComposite;
use AlecRabbit\Spinner\Extras\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Extras\Widget\WidgetContext;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetCompositeTest extends TestCase
{
    #[Test]
    public function intervalIsUpdatedOnContextAdd(): void
    {
        $intervalComparator = new IntervalComparator();
        $children = new WidgetCompositeChildrenContainer();

        $interval = new Interval(100);

        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $widgetComposite = $this->getTesteeInstance(
            revolver: $revolver,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
            intervalComparator: $intervalComparator,
            children: $children,
        );

        self::assertSame($interval, $widgetComposite->getInterval());

        $interval1 = new Interval(120);
        $widget1 = $this->getWidgetMock();
        $widget1
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval1)
        ;

        $context1 = new WidgetContext($widget1);

        $widgetComposite->add($context1);

        self::assertSame($interval, $widgetComposite->getInterval());

        $interval2 = new Interval(85);
        $widget2 = $this->getWidgetMock();
        $widget2
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval2)
        ;

        $context2 = new WidgetContext($widget2);

        $widgetComposite->add($context2);

        self::assertSame($interval2, $widgetComposite->getInterval());
    }

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    public function getTesteeInstance(
        ?IRevolver $revolver = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IIntervalComparator $intervalComparator = null,
        ?IWidgetCompositeChildrenContainer $children = null,
        ?IObserver $observer = null,
    ): IWidgetComposite {
        return
            new WidgetComposite(
                revolver: $revolver ?? $this->getWidgetRevolverMock(),
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
                children: $children ?? $this->getWidgetCompositeChildrenContainerMock(),
                observer: $observer,
            );
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    private function getWidgetCompositeChildrenContainerMock(): MockObject&IWidgetCompositeChildrenContainer
    {
        return $this->createMock(IWidgetCompositeChildrenContainer::class);
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    #[Test]
    public function canGetFrame(): void
    {
        $children = new WidgetCompositeChildrenContainer();

        $revolverFrame = $this->getFrameMock();
        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getFrame')
            ->willReturn($revolverFrame)
        ;

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();

        $widgetComposite = $this->getTesteeInstance(
            revolver: $revolver,
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
            children: $children,
        );

        $otherWidgetContext1 = $this->getWidgetContextMock();
        $otherWidget1 = $this->getWidgetMock();
        $otherWidgetContext1
            ->method('getWidget')
            ->willReturn($otherWidget1)
        ;

        $otherWidget1
            ->method('getFrame')
            ->willReturn(new CharFrame('o1', 2))
        ;
        $otherWidgetContext2 = $this->getWidgetContextMock();
        $otherWidget2 = $this->getWidgetMock();
        $otherWidgetContext2
            ->method('getWidget')
            ->willReturn($otherWidget2)
        ;

        $otherWidget2
            ->method('getFrame')
            ->willReturn(new CharFrame('o2', 2))
        ;

        $widgetComposite->add($otherWidgetContext1);
        $widgetComposite->add($otherWidgetContext2);

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

        $result = $widgetComposite->getFrame();

        self::assertSame('lsrfstso1o2', $result->getSequence());
        self::assertSame(11, $result->getWidth());
    }

    protected function getWidgetContextMock(): MockObject&IWidgetContext
    {
        return $this->createMock(IWidgetContext::class);
    }
}
