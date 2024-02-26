<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
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
        ?ISequenceStateBuilder $stateBuilder = null,
        ?ISequenceState $state = null,
        ?IObserver $observer = null,
    ): ISpinner {
        return new Spinner(
            widget: $widget ?? $this->getWidgetMock(),
            stateBuilder: $stateBuilder ?? $this->getStateBuilderMock(),
            state: $state ?? $this->getStateMock(),
            observer: $observer,
        );
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    private function getStateBuilderMock(): MockObject&ISequenceStateBuilder
    {
        return $this->createMock(ISequenceStateBuilder::class);
    }

    protected function getSequenceFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    #[Test]
    public function canGetState(): void
    {
        $dt = 10;
        $sequence = 'sequence';
        $width = 8;
        $frame = $this->getSequenceFrameMock();
        $frame
            ->expects($this->once())
            ->method('getSequence')
            ->willReturn($sequence)
        ;
        $frame
            ->expects($this->once())
            ->method('getWidth')
            ->willReturn($width)
        ;


        $widget = $this->getWidgetMock();
        $widget
            ->expects($this->once())
            ->method('getFrame')
            ->with($dt)
            ->willReturn($frame)
        ;

        $state = $this->getStateMock();
        $stateBuilder = $this->getStateBuilderMock();
        $stateBuilder
            ->expects($this->once())
            ->method('withSequence')
            ->with($sequence)
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects($this->once())
            ->method('withWidth')
            ->with($width)
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects($this->once())
            ->method('withPreviousWidth')
            ->with(0)
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects($this->once())
            ->method('build')
            ->willReturn($state)
        ;

        $spinner = $this->getTesteeInstance(
            widget: $widget,
            stateBuilder: $stateBuilder,
        );

        self::assertSame($state, $spinner->getState($dt));
    }
    #[Test]
    public function canGetCurrentState(): void
    {
        $dt = null;
        $frame = $this->getSequenceFrameMock();
        $frame
            ->expects($this->never())
            ->method('getSequence')
        ;
        $frame
            ->expects($this->never())
            ->method('getWidth')
        ;


        $widget = $this->getWidgetMock();
        $widget
            ->expects($this->never())
            ->method('getFrame')
        ;

        $initialState = $this->getStateMock();
        $stateBuilder = $this->getStateBuilderMock();
        $stateBuilder
            ->expects($this->never())
            ->method('withSequence')
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects($this->never())
            ->method('withWidth')
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects($this->never())
            ->method('withPreviousWidth')
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects($this->never())
            ->method('build')
        ;

        $spinner = $this->getTesteeInstance(
            widget: $widget,
            stateBuilder: $stateBuilder,
            state: $initialState,
        );

        self::assertSame($initialState, $spinner->getState($dt));
    }

    private function getStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
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

        self::assertNull(self::getPropertyValue('observer', $spinner));

        $spinner->attach($observer);

        self::assertSame($observer, self::getPropertyValue('observer', $spinner));
    }

    #[Test]
    public function canDetachObserver(): void
    {
        $observer = $this->getObserverMock();

        $spinner = $this->getTesteeInstance(
            observer: $observer
        );

        self::assertSame($observer, self::getPropertyValue('observer', $spinner));

        $spinner->detach($observer);

        self::assertNull(self::getPropertyValue('observer', $spinner));
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
}
