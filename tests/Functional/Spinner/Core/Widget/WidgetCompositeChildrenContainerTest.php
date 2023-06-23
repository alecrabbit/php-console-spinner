<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\INullableIntervalContainer;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Core\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetContext;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use WeakMap;

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

        $container = $this->getTesteeInstance(
            map: new \WeakMap(),
        );
        self::assertNull($container->getInterval());

        $context = new WidgetContext();

//        $container->add($context);

        $context->setWidget($widget);
        self::assertSame($interval, $context->getInterval());

        $container->add($context);

        self::assertSame($interval, $container->getInterval());

        $context->setWidget($newWidget);
        self::assertSame($newInterval, $container->getInterval());
    }

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
