<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SpinnerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $spinner = $this->getTesteeInstance();

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    private function getTesteeInstance(
        ?IWidget $widget = null,
        ?ISequenceStateFactory $stateFactory = null,
        ?ISequenceState $state = null,
        ?IObserver $observer = null,
    ): ISpinner {
        return new Spinner(
            widget: $widget ?? $this->getWidgetMock(),
            stateFactory: $stateFactory ?? $this->getStateFactoryMock(),
            state: $state ?? $this->getStateMock(),
            observer: $observer,
        );
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    private function getStateFactoryMock(): MockObject&ISequenceStateFactory
    {
        return $this->createMock(ISequenceStateFactory::class);
    }

    private function getStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
    }

    #[Test]
    public function canGetInitialState(): void
    {
        $widget = $this->getWidgetMock();
        $widget
            ->expects($this->never())
            ->method('getFrame')
        ;

        $initialState = $this->getStateMock();
        $stateFactory = $this->getStateFactoryMock();
        $stateFactory
            ->expects(self::never())
            ->method('create')
        ;

        $spinner = $this->getTesteeInstance(
            widget: $widget,
            stateFactory: $stateFactory,
            state: $initialState,
        );

        self::assertSame($initialState, $spinner->getState());
    }

    #[Test]
    public function canNotifyOnUpdateFromRootWidget(): void
    {
        $rootWidget = $this->getWidgetMock();
        $observer = $this->getObserverMock();
        $observer
            ->expects($this->once())
            ->method('update')
        ;
        $spinner = $this->getTesteeInstance(
            widget: $rootWidget,
            observer: $observer
        );

        self::assertInstanceOf(Spinner::class, $spinner);

        $spinner->update($rootWidget);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function willNotNotifyOnUpdateFromOtherWidget(): void
    {
        $otherWidget = $this->getWidgetMock();
        $rootWidget = $this->getWidgetMock();
        $observer = $this->getObserverMock();
        $observer
            ->expects(self::never())
            ->method('update')
        ;
        $spinner = $this->getTesteeInstance(
            widget: $rootWidget,
            observer: $observer
        );

        self::assertInstanceOf(Spinner::class, $spinner);

        $spinner->update($otherWidget);
    }

    #[Test]
    public function canBeAttachedAsObserverToRootWidget(): void
    {
        $rootWidget = $this->getWidgetMock();
        $rootWidget
            ->expects($this->once())
            ->method('attach')
        ;

        $spinner = $this->getTesteeInstance(
            widget: $rootWidget,
        );

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $rootWidget = $this->getWidgetMock();
        $rootWidget
            ->expects($this->once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $spinner = $this->getTesteeInstance(widget: $rootWidget);

        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($interval, $spinner->getInterval());
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canAttachObserver(): void
    {
        $spinner = $this->getTesteeInstance();

        $observer = $this->getObserverMock();

        self::assertNull(self::getPropertyValue($spinner, 'observer'));

        $spinner->attach($observer);

        self::assertSame($observer, self::getPropertyValue($spinner, 'observer'));
    }

    #[Test]
    public function canDetachObserver(): void
    {
        $observer = $this->getObserverMock();

        $spinner = $this->getTesteeInstance(
            observer: $observer
        );

        self::assertSame($observer, self::getPropertyValue($spinner, 'observer'));

        $spinner->detach($observer);

        self::assertNull(self::getPropertyValue($spinner, 'observer'));
    }

    #[Test]
    public function throwsIfObserverAlreadyAttached(): void
    {
        $exceptionClass = ObserverCanNotBeOverwritten::class;
        $exceptionMessage = 'Observer is already attached.';

        $test = function (): void {
            $observer = $this->getObserverMock();
            $spinner = $this->getTesteeInstance(
                observer: $observer
            );
            $spinner->attach($observer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfObserverAttachedIsSelf(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $spinner = $this->getTesteeInstance();
            $spinner->attach($spinner);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    private function getSequenceFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    private function getStateBuilderMock(): MockObject&ISequenceStateBuilder
    {
        return $this->createMock(ISequenceStateBuilder::class);
    }
}
