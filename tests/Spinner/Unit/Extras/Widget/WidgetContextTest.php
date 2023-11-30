<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Extras\Widget\WidgetContext;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetContextTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetContext = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
    }

    public function getTesteeInstance(
        ?IWidget $widget = null,
        ?IObserver $observer = null,
    ): IWidgetContext {
        return new WidgetContext(
            widget: $widget,
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

    protected function getWidgetCompositeMock(): MockObject&IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
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

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    #[Test]
    public function canGetIntervalFromUnderlyingWidget(): void
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

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function returnsNullOnGetIntervalIfWidgetIsNotSet(): void
    {
        $widgetContext = $this->getTesteeInstance();

        self::assertNull($widgetContext->getInterval());
    }

    #[Test]
    public function canSetWidgetComposite(): void
    {
        $widgetContext = $this->getTesteeInstance();

        self::assertNull($widgetContext->getWidget());

        $widgetComposite = $this->getWidgetCompositeMock();
        $widgetComposite
            ->expects(self::once())
            ->method('attach')
            ->with($widgetContext)
        ;

        $widgetContext->setWidget($widgetComposite);

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widgetComposite, $widgetContext->getWidget());
    }

    #[Test]
    public function canReplaceWidgetWithWidgetComposite(): void
    {
        $widget = $this->getWidgetMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widget,
        );

        $widget
            ->expects(self::once())
            ->method('detach')
            ->with($widgetContext)
        ;

        $widgetComposite = $this->getWidgetCompositeMock();
        $widgetComposite
            ->expects(self::once())
            ->method('attach')
            ->with($widgetContext)
        ;

        $widgetContext->setWidget($widgetComposite);

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widgetComposite, $widgetContext->getWidget());
    }

    #[Test]
    public function canReplaceWidgetCompositeWithWidget(): void
    {
        $widgetComposite = $this->getWidgetCompositeMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
        );
        $widgetComposite
            ->expects(self::once())
            ->method('detach')
            ->with($widgetContext)
        ;
        $widget = $this->getWidgetMock();
        $widget
            ->expects(self::once())
            ->method('attach')
            ->with($widgetContext)
        ;

        $widgetContext->setWidget($widget);

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widget, $widgetContext->getWidget());
    }

    #[Test]
    public function canSetWidgetToNull(): void
    {
        $widgetComposite = $this->getWidgetCompositeMock();

        $observer = $this->getObserverMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
            observer: $observer,
        );
        $observer
            ->expects(self::once())
            ->method('update')
            ->with($widgetContext)
        ;

        $widgetComposite
            ->expects(self::once())
            ->method('detach')
            ->with($widgetContext)
        ;
        $widget = null;

        $widgetContext->setWidget($widget);

        self::assertNull($widgetContext->getWidget());
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function canSetWidget(): void
    {
        $widgetComposite = $this->getWidgetCompositeMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
        );

        $widget = $this->getWidgetMock();

        $widgetContext->setWidget($widget);

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widget, $widgetContext->getWidget());
    }

    #[Test]
    public function canNotifyOnUpdateFromWidgetComposite(): void
    {
        $widgetComposite = $this->getWidgetCompositeMock();

        $observer = $this->getObserverMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
            observer: $observer,
        );
        $observer
            ->expects(self::once())
            ->method('update')
            ->with($widgetContext)
        ;
        $widgetContext->update($widgetComposite);
    }

    #[Test]
    public function willNotifyOnSetWidget(): void
    {
        $widgetComposite = $this->getWidgetCompositeMock();

        $observer = $this->getObserverMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widgetComposite,
            observer: $observer,
        );
        $observer
            ->expects(self::once())
            ->method('update')
            ->with($widgetContext)
        ;
        $widgetContext->setWidget($widgetComposite);
    }

    #[Test]
    public function willNotNotifyOnUpdateFromOtherWidget(): void
    {
        $otherWidget = $this->getWidgetMock();
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

        $widgetContext->update($otherWidget);
    }

    #[Test]
    public function willNotifyOnConstructWithWidget(): void
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

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
    }

    #[Test]
    public function willNotNotifyOnConstructIfWidgetIsNull(): void
    {
        $observer = $this->getObserverMock();
        $observer
            ->expects(self::never())
            ->method('update')
        ;

        $widgetContext = $this->getTesteeInstance(
            observer: $observer,
        );

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
    }

    #[Test]
    public function returnsNullIfWidgetIsNotSet(): void
    {
        $widgetContext = $this->getTesteeInstance();
        self::assertNull($widgetContext->getWidget());
    }
}
