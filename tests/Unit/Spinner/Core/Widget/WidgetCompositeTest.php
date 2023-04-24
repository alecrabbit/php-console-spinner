<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetObserverAndSubject;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetCompositeTest extends TestCaseWithPrebuiltMocksAndStubs
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
    ): IWidgetObserverAndSubject {
        return new Widget(
            revolver: $revolver ?? $this->getRevolverMock(),
            leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
            trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
        );
    }

    #[Test]
    public function canAttachObservers(): void
    {
        $widget = $this->getTesteeInstance();

        $observer1 = $this->getWidgetObserverAndSubjectMock();
        $observer2 = $this->getWidgetObserverAndSubjectMock();

        $widget->attach($observer1);
        $widget->attach($observer2);

        /** @var \WeakMap $observers */
        $observers = self::getPropertyValue('observers', $widget);

        self::assertSame($observer1, $observers[$observer1]);
        self::assertSame($observer2, $observers[$observer2]);
    }

    #[Test]
    public function canDetachObservers(): void
    {
        $widget = $this->getTesteeInstance();

        $observer1 = $this->getWidgetObserverAndSubjectMock();
        $observer2 = $this->getWidgetObserverAndSubjectMock();

        $widget->attach($observer1);
        $widget->attach($observer2);

        $widget->detach($observer1);

        /** @var \WeakMap $observers */
        $observers = self::getPropertyValue('observers', $widget);

        self::assertFalse($observers->offsetExists($observer1));
        self::assertSame($observer2, $observers[$observer2]);
    }

    #[Test]
    public function canNotifyObservers(): void
    {
        $widget = $this->getTesteeInstance();

        $observer1 = $this->getWidgetObserverAndSubjectMock();
        $observer1
            ->expects(self::once())
            ->method('update')
            ->with($widget)
        ;
        $observer2 = $this->getWidgetObserverAndSubjectMock();
        $observer2
            ->expects(self::once())
            ->method('update')
            ->with($widget)
        ;

        $widget->attach($observer1);
        $widget->attach($observer2);

        $widget->notify();
    }

    #[Test]
    public function canBeUpdatedWithSubject(): void
    {
        $widget = $this->getTesteeInstance();

        $subject = $this->getWidgetObserverAndSubjectMock();
        $subject
            ->expects(self::once())
            ->method('getInterval')
        ;

        $widget->update($subject);
    }

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
    public function canAddWidgets(): void
    {
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::exactly(2))
            ->method('smallest')
            ->willReturnSelf()
        ;

        $revolver = $this->getRevolverMock();
        $revolver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $composite = $this->getTesteeInstance(
            revolver: $revolver,
        );

        $observer1 = $this->getWidgetObserverAndSubjectMock();
        $observer1
            ->expects(self::exactly(2))
            ->method('update')
            ->with($composite)
        ;

        $observer2 = $this->getWidgetObserverAndSubjectMock();
        $observer2
            ->expects(self::exactly(2))
            ->method('update')
            ->with($composite)
        ;

        $widget1Interval = $this->getIntervalMock();
        $widget1 = $this->getWidgetObserverAndSubjectMock();
        $widget1
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($widget1Interval)
        ;
        $widget1
            ->expects(self::once())
            ->method('attach')
            ->with($composite)
        ;

        $widget2Interval = $this->getIntervalMock();
        $widget2 = $this->getWidgetObserverAndSubjectMock();
        $widget2
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($widget2Interval)
        ;
        $widget2
            ->expects(self::once())
            ->method('attach')
            ->with($composite)
        ;


        $composite->attach($observer1);
        $composite->attach($observer2);

        $composite->add($widget1);
        $composite->add($widget2);

        /** @var \WeakMap $children */
        $children = self::getPropertyValue('children', $composite);

        self::assertTrue($children->offsetExists($widget1));
        self::assertTrue($children->offsetExists($widget2));
    }

    #[Test]
    public function canRemoveWidgets(): void
    {
        $composite = $this->getTesteeInstance(

        );
        $observer1 = $this->getWidgetObserverAndSubjectMock();
        $widget1 = $this->getWidgetObserverAndSubjectMock();
        $widget2 = $this->getWidgetObserverAndSubjectMock();

        /** @var \WeakMap $observers */
        $observers = self::getPropertyValue('observers', $composite);
        $observers->offsetSet($observer1, $observer1);

        /** @var \WeakMap $children */
        $children = self::getPropertyValue('children', $composite);
        $children->offsetSet($widget1, $widget1);
        $children->offsetSet($widget2, $widget2);


        $observer1
            ->expects(self::exactly(2))
            ->method('update')
            ->with($composite)
        ;

        $widget1Interval = $this->getIntervalMock();

        $widget1
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($widget1Interval)
        ;
        $widget1
            ->expects(self::once())
            ->method('detach')
            ->with($composite)
        ;

        $widget2Interval = $this->getIntervalMock();

        $widget2
            ->expects(self::never())
            ->method('getInterval')
            ->willReturn($widget2Interval)
        ;
        $widget2
            ->expects(self::once())
            ->method('detach')
            ->with($composite)
        ;

        $composite->remove($widget2);
        self::assertFalse($children->offsetExists($widget2));
        $composite->remove($widget1);
        self::assertFalse($children->offsetExists($widget1));

    }

    #[Test]
    public function removingNonExistentWidgetDoesNothing(): void
    {
        $composite = $this->getTesteeInstance();

        $widget1 = $this->getWidgetObserverAndSubjectMock();
        $widget1
            ->expects(self::once())
            ->method('detach')
            ->with($composite)
        ;

        /** @var \WeakMap $children */
        $children = self::getPropertyValue('children', $composite);
        $children->offsetSet($widget1, $widget1);

        $composite->remove($this->getWidgetObserverAndSubjectMock());

        $composite->remove($widget1);
        self::assertFalse($children->offsetExists($widget1));
    }

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
