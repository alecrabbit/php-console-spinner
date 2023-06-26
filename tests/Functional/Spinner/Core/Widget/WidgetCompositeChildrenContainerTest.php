<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Core\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetContext;
use AlecRabbit\Spinner\Core\WidgetContextToIntervalMap;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use PHPUnit\Framework\Attributes\Test;

final class WidgetCompositeChildrenContainerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeUpdatedByAddedContext(): void
    {
        $interval = new Interval(100);
        $newInterval = new Interval(80);

        $revolver = $this->getRevolverMock();
        $revolver
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $newRevolver = $this->getRevolverMock();
        $newRevolver
            ->method('getInterval')
            ->willReturn($newInterval)
        ;

        $widget = new Widget(
            revolver: $revolver,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $newWidget = new Widget(
            revolver: $newRevolver,
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

    #[Test]
    public function canBeUpdatedByRemovedContext(): void
    {
        $interval1 = new Interval(100);
        $interval2 = new Interval(80);
        $interval3 = new Interval(120);

        $revolver1 = $this->getRevolverMock();
        $revolver1
            ->method('getInterval')
            ->willReturn($interval1)
        ;

        $revolver2 = $this->getRevolverMock();
        $revolver2
            ->method('getInterval')
            ->willReturn($interval2)
        ;
        $revolver3 = $this->getRevolverMock();
        $revolver3
            ->method('getInterval')
            ->willReturn($interval3)
        ;

        $widget1 = new Widget(
            revolver: $revolver1,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $widget2 = new Widget(
            revolver: $revolver2,
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );

        $widget3 = new Widget(
            revolver: $revolver3,
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
    public function canBeCreated(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeChildrenContainer::class, $container);
    }
}
