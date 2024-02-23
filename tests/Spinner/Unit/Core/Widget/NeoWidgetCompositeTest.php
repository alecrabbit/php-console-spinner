<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Widget\Contract\INeoWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\NeoWidgetComposite;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NeoWidgetCompositeTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $composite = $this->getTesteeInstance();

        self::assertInstanceOf(NeoWidgetComposite::class, $composite);
    }

    public function getTesteeInstance(
        ?\WeakMap $widgets = null,
        ?IIntervalComparator $intervalComparator = null,
        ?IObserver $observer = null,
    ): INeoWidgetComposite {
        return
            new NeoWidgetComposite(
                widgets: $widgets ?? new \WeakMap(),
                intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
                observer: $observer ?? $this->getObserverMock(),
            );
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    private function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function canAdd(): void
    {
        $widgets = new \WeakMap();

        $composite = $this->getTesteeInstance(
            widgets: $widgets,
        );

        $interval = new Interval(100);
        $widget = $this->getWidgetMock();
        $widget
            ->method('getInterval')
            ->willReturn($interval);

        self::assertEquals(new Interval(), $composite->getInterval());

        $placeholder = $composite->add($widget);

        self::assertTrue($widgets->offsetExists($placeholder));
        self::assertSame($widget, $widgets->offsetGet($placeholder));
        self::assertSame($interval, $widget->getInterval());
        self::assertCount(1, $widgets);
    }

    private function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    #[Test]
    public function canAddAndRemoveWithPlaceholder(): void
    {
        $widgets = new \WeakMap();

        $composite = $this->getTesteeInstance(
            widgets: $widgets,
        );

        $interval = new Interval(100);
        $widget = $this->getWidgetMock();
        $widget
            ->method('getInterval')
            ->willReturn($interval);

        $placeholder = $composite->add($widget);

        self::assertTrue($widgets->offsetExists($placeholder));
        self::assertSame($widget, $widgets->offsetGet($placeholder));
        self::assertSame($interval, $widget->getInterval());
        self::assertCount(1, $widgets);

        $composite->remove($placeholder);

        self::assertFalse($widgets->offsetExists($placeholder));
        self::assertCount(0, $widgets);
        self::assertEquals(new Interval(), $composite->getInterval());

        $composite->remove($placeholder);
    }

    #[Test]
    public function canAddAndRemoveWithWidget(): void
    {
        $widgets = new \WeakMap();

        $composite = $this->getTesteeInstance(
            widgets: $widgets,
        );

        $interval = $this->getIntervalMock();
        $widget = $this->getWidgetMock();

        $placeholder = $composite->add($widget);

        self::assertTrue($widgets->offsetExists($placeholder));
        self::assertSame($widget, $widgets->offsetGet($placeholder));

        $composite->remove($widget);

        self::assertFalse($widgets->offsetExists($placeholder));
        self::assertCount(0, $widgets);
        self::assertEquals(new Interval(), $composite->getInterval());

        $composite->remove($widget);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }
}
