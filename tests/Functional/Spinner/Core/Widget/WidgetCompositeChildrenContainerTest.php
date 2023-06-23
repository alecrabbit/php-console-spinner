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
