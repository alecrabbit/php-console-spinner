<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Core\Widget\WidgetContextContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widget = $this->getTesteeInstance();

        self::assertInstanceOf(Widget::class, $widget);
    }

    public function getTesteeInstance(
        ?IRevolver $revolver = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IWidgetContextContainer $children = null,
        ?IObserver $observer = null,
    ): IWidget {
        return new Widget(
            revolver: $revolver ?? $this->getRevolverMock(),
            leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
            trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
            children: $children ?? $this->getWidgetContextContainerMock(),
            observer: $observer,
        );
    }

    #[Test]
    public function canAttachObserver(): void
    {
        $widget = $this->getTesteeInstance();

        $observer = $this->getObserverMock();

        self::assertNull(self::getPropertyValue('observer', $widget));

        $widget->attach($observer);

        self::assertSame($observer, self::getPropertyValue('observer', $widget));
    }

    #[Test]
    public function canDetachObserver(): void
    {
        $observer = $this->getObserverMock();

        $widget = $this->getTesteeInstance(
            observer: $observer
        );

        self::assertSame($observer, self::getPropertyValue('observer', $widget));

        $widget->detach($observer);

        self::assertNull(self::getPropertyValue('observer', $widget));
    }
//
//    #[Test]
//    public function canNotifyObservers(): void
//    {
//        $widget = $this->getTesteeInstance();
//
//        $observer1 = $this->getWidgetMock();
//        $observer1
//            ->expects(self::once())
//            ->method('update')
//            ->with($widget)
//        ;
//        $observer2 = $this->getWidgetMock();
//        $observer2
//            ->expects(self::once())
//            ->method('update')
//            ->with($widget)
//        ;
//
//        $widget->attach($observer1);
//        $widget->attach($observer2);
//
//        $widget->notify();
//    }
//
//    #[Test]
//    public function canBeUpdatedWithSubject(): void
//    {
//        $widget = $this->getTesteeInstance();
//
//        $subject = $this->getWidgetMock();
//        $subject
//            ->expects(self::once())
//            ->method('getInterval')
//        ;
//
//        $widget->update($subject);
//    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $revolver = $this->getRevolverMock();
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
    #[Test]
    public function canGetContext(): void
    {
        $widget = $this->getTesteeInstance();

        $context = self::getPropertyValue('context', $widget);

        self::assertSame($context, $widget->getContext());
    }
//
//    #[Test]
//    public function canAddWidgets(): void
//    {
//        $interval = $this->getIntervalMock();
//        $interval
////            ->expects(self::exactly(2))
//            ->method('smallest')
//            ->willReturnSelf()
//        ;
//
//        $revolver = $this->getRevolverMock();
//        $revolver
//            ->expects(self::once())
//            ->method('getInterval')
//            ->willReturn($interval)
//        ;
//
//        $widgetContextContainer = new WidgetContextContainer();
//
//        $composite = $this->getTesteeInstance(
//            revolver: $revolver,
//            contexts: $widgetContextContainer,
//        );
//
//        $observer1 = $this->getWidgetMock();
//        $observer1
////            ->expects(self::exactly(2))
//            ->method('update')
//            ->with($composite)
//        ;
//
//        $observer2 = $this->getWidgetMock();
//        $observer2
////            ->expects(self::exactly(2))
//            ->method('update')
//            ->with($composite)
//        ;
//
//        $context1 = $this->getWidgetContextMock();
//        $widget1Interval = $this->getIntervalMock();
//        $widget1 = $this->getWidgetMock();
//        $widget1
//            ->expects(self::once())
//            ->method('getContext')
//            ->willReturn($context1)
//        ;
//        $widget1
//            ->expects(self::once())
//            ->method('getInterval')
//            ->willReturn($widget1Interval)
//        ;
//        $widget1
//            ->expects(self::once())
//            ->method('attach')
//            ->with($composite)
//        ;
//
//        $context2 = $this->getWidgetContextMock();
//        $widget2Interval = $this->getIntervalMock();
//        $widget2 = $this->getWidgetMock();
//        $widget2
//            ->expects(self::once())
//            ->method('getContext')
//            ->willReturn($context2)
//        ;
//        $widget2
//            ->expects(self::once())
//            ->method('getInterval')
//            ->willReturn($widget2Interval)
//        ;
//        $widget2
//            ->expects(self::once())
//            ->method('attach')
//            ->with($composite)
//        ;
//
//        $composite->attach($observer1);
//        $composite->attach($observer2);
//
//        $composite->add($widget1);
//        $composite->add($widget2);
//    }
//
//    #[Test]
//    public function canRemoveWidgets(): void
//    {
//        $container = new WidgetContextContainer();
//        $composite = $this->getTesteeInstance(
//            contexts: $container,
//        );
//
//        $observer1 = $this->getComboSubjectObserverMock();
//
//        $widget1 = $this->getWidgetMock();
//        $widget2 = $this->getWidgetMock();
//
//        /** @var \WeakMap $observers */
//        $observers = self::getPropertyValue('observers', $composite);
//        $observers->offsetSet($observer1, $observer1);
//
//        $observer1
//            ->expects(self::exactly(2))
//            ->method('update')
//            ->with($composite)
//        ;
//
//        $widget1Interval = $this->getIntervalMock();
//
//        $widget1
//            ->expects(self::once())
//            ->method('getInterval')
//            ->willReturn($widget1Interval)
//        ;
//        $widget1
//            ->expects(self::once())
//            ->method('detach')
//            ->with($composite)
//        ;
//
//        $widget2Interval = $this->getIntervalMock();
//
//        $widget2
//            ->expects(self::never())
//            ->method('getInterval')
//            ->willReturn($widget2Interval)
//        ;
//        $widget2
//            ->expects(self::once())
//            ->method('detach')
//            ->with($composite)
//        ;
//
//        $composite->remove($widget2);
//        $composite->remove($widget1);
//    }

//    #[Test]
//    public function removingNonExistentWidgetDoesNothing(): void
//    {
//        $composite = $this->getTesteeInstance();
//
//        $widget1 = $this->getWidgetMock();
//        $widget1
//            ->expects(self::once())
//            ->method('detach')
//            ->with($composite)
//        ;
//
//        /** @var \WeakMap $children */
//        $children = self::getPropertyValue('children', $composite);
//        $children->offsetSet($widget1, $widget1);
//
//        $composite->remove($this->getWidgetMock());
//
//        $composite->remove($widget1);
//        self::assertFalse($children->offsetExists($widget1));
//    }

    #[Test]
    public function throwsIfObserverIsSelf(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $widget = $this->getTesteeInstance();
            $widget->attach($widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }
    #[Test]
    public function throwsIfObserverAlreadyAttached(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Observer is already attached.';

        $test = function (): void {
            $widget = $this->getTesteeInstance();
            $observer = $this->getObserverMock();
            $widget->attach($observer);
            $widget->attach($observer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfAddedWidgetIsSelf(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $widget = $this->getTesteeInstance();
            $widget->add($widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }

}
