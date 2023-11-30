<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Extras\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Extras\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Extras\Widget\WidgetContext;
use AlecRabbit\Spinner\Extras\Widget\WidgetContextToIntervalMap;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetCompositeChildrenContainerTest extends TestCase
{
    #[Test]
    public function canBeUpdatedByAddedContext(): void
    {
        $interval = new Interval(100);
        $newInterval = new Interval(80);

        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $newRevolver = $this->getWidgetRevolverMock();
        $newRevolver
            ->method('getInterval')
            ->willReturn($newInterval)
        ;

        $widget = new Widget(
            widgetRevolver: $revolver,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $newWidget = new Widget(
            widgetRevolver: $newRevolver,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $container = $this->getTesteeInstance();
        self::assertNull($container->getInterval());

        $context = new WidgetContext();

        $container->add($context);

        $context->setWidget($widget);
        self::assertSame($interval, $context->getInterval());

        $container->add($context); // should have no effect

        self::assertSame($interval, $container->getInterval());

        $context->setWidget($newWidget);
        self::assertSame($newInterval, $container->getInterval());
    }

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    public function getTesteeInstance(
        null|(ArrayAccess&Countable&IteratorAggregate) $map = null,
        ?IObserver $observer = null,
    ): IWidgetCompositeChildrenContainer {
        return new WidgetCompositeChildrenContainer(
            map: $map ?? new WidgetContextToIntervalMap(),
            observer: $observer,
        );
    }

    #[Test]
    public function canBeUpdatedWhenContextIsRemovedOne(): void
    {
        $interval1 = new Interval(100);
        $interval2 = new Interval(80);
        $interval3 = new Interval(120);

        $revolver1 = $this->getWidgetRevolverMock();
        $revolver1
            ->method('getInterval')
            ->willReturn($interval1)
        ;

        $revolver2 = $this->getWidgetRevolverMock();
        $revolver2
            ->method('getInterval')
            ->willReturn($interval2)
        ;
        $revolver3 = $this->getWidgetRevolverMock();
        $revolver3
            ->method('getInterval')
            ->willReturn($interval3)
        ;

        $widget1 = new Widget(
            widgetRevolver: $revolver1,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $widget2 = new Widget(
            widgetRevolver: $revolver2,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $widget3 = new Widget(
            widgetRevolver: $revolver3,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $container = $this->getTesteeInstance();
        self::assertNull($container->getInterval());

        $context1 = new WidgetContext();
        $context2 = new WidgetContext();
        $context3 = new WidgetContext();
        $context3->setWidget($widget3);

        $container->add($context1);
        $container->add($context2);
        $container->add($context3);

        self::assertSame($interval3, $container->getInterval());

        $context1->setWidget($widget1);
        self::assertSame($interval1, $container->getInterval());

        $context2->setWidget($widget2);
        self::assertSame($interval2, $container->getInterval());

        $container->remove($context2);
        self::assertSame($interval1, $container->getInterval());
    }

    #[Test]
    public function canBeUpdatedWhenContextIsRemovedTwo(): void
    {
        $interval = new Interval(80);

        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->method('getInterval')
            ->willReturn($interval)
        ;


        $widget = new Widget(
            widgetRevolver: $revolver,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );


        $container = $this->getTesteeInstance();
        self::assertNull($container->getInterval());

        $context1 = new WidgetContext();
        $context2 = new WidgetContext();
        $context3 = new WidgetContext();

        $container->add($context1);
        $container->add($context2);
        $container->add($context3);

        self::assertNull($container->getInterval());

        $context2->setWidget($widget);
        self::assertSame($interval, $container->getInterval());

        $container->remove($context2);
        self::assertNull($container->getInterval());
    }

    #[Test]
    public function canBeUpdatedWhenContextIsRemovedFour(): void
    {
        $interval = new Interval(80);

        $revolver = $this->getWidgetRevolverMock();
        $revolver
            ->method('getInterval')
            ->willReturn($interval)
        ;


        $widget = new Widget(
            widgetRevolver: $revolver,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );


        $container = $this->getTesteeInstance();
        self::assertNull($container->getInterval());

        $context1 = new WidgetContext();
        $context2 = new WidgetContext();
        $context3 = new WidgetContext();

        $context2->setWidget($widget);

        $container->add($context1);
        $container->add($context2);
        $container->add($context3);

        self::assertSame($interval, $container->getInterval());

        $container->remove($context2);
        self::assertNull($container->getInterval());
    }

    #[Test]
    public function canBeUpdatedWhenContextIsRemovedThree(): void
    {
        $interval1 = new Interval(100);
        $interval2 = new Interval(80);
        $interval3 = new Interval(120);

        $revolver1 = $this->getWidgetRevolverMock();
        $revolver1
            ->method('getInterval')
            ->willReturn($interval1)
        ;

        $revolver2 = $this->getWidgetRevolverMock();
        $revolver2
            ->method('getInterval')
            ->willReturn($interval2)
        ;
        $revolver3 = $this->getWidgetRevolverMock();
        $revolver3
            ->method('getInterval')
            ->willReturn($interval3)
        ;

        $widget1 = new Widget(
            widgetRevolver: $revolver1,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $widget2 = new Widget(
            widgetRevolver: $revolver2,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $widget3 = new Widget(
            widgetRevolver: $revolver3,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $container = $this->getTesteeInstance();
        self::assertNull($container->getInterval());

        $context1 = new WidgetContext();
        $context2 = new WidgetContext();
        $context3 = new WidgetContext();

        $context1->setWidget($widget1);
        $context2->setWidget($widget2);
        $context3->setWidget($widget3);

        $container->add($context1);
        $container->add($context2);
        $container->add($context3);

        self::assertSame($interval2, $container->getInterval());

        $container->remove($context2);
        self::assertSame($interval1, $container->getInterval());
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeChildrenContainer::class, $container);
    }
}
