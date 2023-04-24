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

}
