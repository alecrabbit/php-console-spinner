<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\INullableIntervalContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use WeakMap;

final class WidgetCompositeChildrenContainerTest extends TestCaseWithPrebuiltMocksAndStubs
{

//    #[Test]
//    public function canOperateWithIntervals(): void
//    {
//        $intervalContainer = new NullableIntervalContainer();
//
//        $interval0 = new Interval(100);
//        $interval1 = new Interval(200);
//        $interval2 = new Interval(300);
//        $interval3 = new Interval(400);
//        $interval4 = new Interval(800);
//        $interval5 = new Interval(1000);
//
//        $intervalContainer->add($interval0);
//        $intervalContainer->add($interval1);
//        $intervalContainer->add($interval2);
//        $intervalContainer->add($interval3);
//        $intervalContainer->add($interval4);
//        $intervalContainer->add($interval5);
//
//        self::assertSame($interval0, $intervalContainer->getSmallest());
//        $intervalContainer->remove($interval1);
//        self::assertSame($interval0, $intervalContainer->getSmallest());
//        $intervalContainer->remove($interval0);
//        self::assertSame($interval2, $intervalContainer->getSmallest());
//        $intervalContainer->remove($interval2);
//        self::assertSame($interval3, $intervalContainer->getSmallest());
//        $intervalContainer->remove($interval5);
//        self::assertSame($interval3, $intervalContainer->getSmallest());
//        $intervalContainer->remove($interval3);
//        self::assertSame($interval4, $intervalContainer->getSmallest());
//        $intervalContainer->remove($interval4);
//        self::assertNull($intervalContainer->getSmallest());
//    }

//    #[Test]
//    public function observerGetsNotifiedAndCanGetInterval(): void
//    {
//        $observer = $this->getObserverMock();
//
//        $container = $this->getTesteeInstance(
//            observer: $observer,
//        );
//
//        $observer
//            ->expects(self::once())
//            ->method('update')
//            ->with($container)
//        ;
//
//        $context = $this->getWidgetContextMock();
//
//        $container->add($context);
//    }

    public function getTesteeInstance(
        ?WeakMap $map = null,
        ?INullableIntervalContainer $intervalContainer = null,
        ?IObserver $observer = null,
    ): IWidgetCompositeChildrenContainer {
        return new WidgetCompositeChildrenContainer(
            map: $map ?? new WeakMap(),
//            intervalContainer: $intervalContainer ?? $this->getNullableIntervalContainerMock(),
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
