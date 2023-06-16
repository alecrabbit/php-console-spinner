<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\WidgetContext;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetContextTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widgetContext = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
    }

    public function getTesteeInstance(
        ?IWidget $widget = null,
        ?IObserver $observer = null,
    ): IWidgetContext {
        return new WidgetContext(
            widget: $widget ?? $this->getWidgetMock(),
            observer: $observer,
        );
    }

    #[Test]
    public function canGetWidgetComposite(): void
    {
        $widgetComposite = $this->getWidgetCompositeMock();
        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
        );

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widgetComposite, $widgetContext->getWidget());
    }

    #[Test]
    public function canGetWidget(): void
    {
        $widget = $this->getWidgetMock();
        $widgetContext = $this->getTesteeInstance(
            widget: $widget,
        );

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widget, $widgetContext->getWidget());
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $widget = $this->getWidgetMock();
        $widget
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $widgetContext = $this->getTesteeInstance(
            widget: $widget,
        );

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($interval, $widgetContext->getInterval());
    }

    #[Test]
    public function canReplaceWidget(): void
    {
        $widget = $this->getWidgetMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widget,
        );

        $widgetComposite = $this->getWidgetCompositeMock();
        $widgetComposite
            ->expects(self::once())
            ->method('replaceContext')
            ->with($widgetContext)
        ;

        $widgetContext->replaceWidget($widgetComposite);

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widgetComposite, $widgetContext->getWidget());
    }

    #[Test]
    public function canReplaceWidgetComposite(): void
    {
        $widgetComposite = $this->getWidgetCompositeMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
        );

        $widget = $this->getWidgetMock();
        $widget
            ->expects(self::once())
            ->method('replaceContext')
            ->with($widgetContext)
        ;

        $widgetContext->replaceWidget($widget);

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widget, $widgetContext->getWidget());
    }

    #[Test]
    public function canNotifyOnUpdateFromRootWidget(): void
    {
        $widgetComposite = $this->getWidgetCompositeMock();

        $observer = $this->getObserverMock();
        $observer
            ->expects(self::once())
            ->method('update')
        ;

        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
            observer: $observer,
        );

        $widgetContext->update($widgetComposite);
    }

    #[Test]
    public function willNotNotifyOnUpdateFromOtherWidget(): void
    {
        $otherWidget = $this->getWidgetMock();
        $widgetComposite = $this->getWidgetCompositeMock();

        $observer = $this->getObserverMock();
        $observer
            ->expects(self::never())
            ->method('update')
        ;

        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
            observer: $observer,
        );

        $widgetContext->update($otherWidget);
    }
}
