<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

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

    public function getTesteeInstance(): Widget
    {
        return new Widget(
            revolver: $this->getRevolverMock(),
            leadingSpacer: $this->getFrameMock(),
            trailingSpacer: $this->getFrameMock(),
        );
    }

    #[Test]
    public function canAttachObservers(): void
    {
        $widget = $this->getTesteeInstance();

        $observer1 = $this->getObserverAndSubjectMock();
        $observer2 = $this->getObserverAndSubjectMock();

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

        $observer1 = $this->getObserverAndSubjectMock();
        $observer2 = $this->getObserverAndSubjectMock();

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

        $observer1 = $this->getObserverAndSubjectMock();
        $observer1
            ->expects(self::once())
            ->method('update')
            ->with($widget)
        ;
        $observer2 = $this->getObserverAndSubjectMock();
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

        $subject = $this->getObserverAndSubjectMock();
        $subject
            ->expects(self::once())
            ->method('getInterval')
        ;

        $widget->update($subject);
    }

    #[Test]
    public function canAddWidgetComposites(): void
    {
        $composite = $this->getTesteeInstance();

        $widget1 = $this->getObserverAndSubjectMock();
        $widget1
            ->expects(self::once())
            ->method('attach')
            ->with($composite);

        $widget2 = $this->getObserverAndSubjectMock();
        $widget2
            ->expects(self::once())
            ->method('attach')
            ->with($composite);

        $composite->add($widget1);
        $composite->add($widget2);

        /** @var \WeakMap $children */
        $children = self::getPropertyValue('children', $composite);

        self::assertTrue($children->offsetExists($widget1));
        self::assertTrue($children->offsetExists($widget2));

    }

    #[Test]
    public function throwsIfObserverIsSelf(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Observer can not be self.';

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

//    #[Test]
//    public function throwsIfAddedWidgetIsSelf(): void
//    {
//        $exceptionClass = InvalidArgumentException::class;
//        $exceptionMessage = 'Object can not be self.';
//
//        $test = function (): void {
//            $widget = $this->getTesteeInstance();
//            $widget->add($widget);
//        };
//
//        $this->wrapExceptionTest(
//            test: $test,
//            exceptionOrExceptionClass: $exceptionClass,
//            exceptionMessage: $exceptionMessage,
//        );
//    }

}
