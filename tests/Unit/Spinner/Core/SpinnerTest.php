<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\WidgetIsNotAComposite;
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

    protected function getTesteeInstance(
        ?IWidget $rootWidget = null,
        ?IObserver $observer = null,
    ): ISpinner {
        return new Spinner(
            widget: $rootWidget ?? $this->getWidgetMock(),
            observer: $observer,
        );
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    #[Test]
    public function canGetFrame(): void
    {
        $frame = $this->getFrameMock();
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('getFrame')
            ->willReturn($frame)
        ;
        $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($frame, $spinner->getFrame());
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getWidgetCompositeMock(): MockObject&IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
    }

    #[Test]
    public function canNotifyOnUpdateFromRootWidget(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $observer = $this->getObserverMock();
        $observer
            ->expects(self::once())
            ->method('update')
        ;
        $spinner = $this->getTesteeInstance(
            rootWidget: $rootWidget,
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
        $rootWidget = $this->getWidgetCompositeMock();
        $observer = $this->getObserverMock();
        $observer
            ->expects(self::never())
            ->method('update')
        ;
        $spinner = $this->getTesteeInstance(
            rootWidget: $rootWidget,
            observer: $observer
        );

        self::assertInstanceOf(Spinner::class, $spinner);

        $spinner->update($otherWidget);
    }

    #[Test]
    public function canBeAttachedAsObserverToRootWidget(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('attach')
        ;

        $spinner = $this->getTesteeInstance(
            rootWidget: $rootWidget,
        );

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

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
    public function canAddWidget(): void
    {
        $context = $this->getWidgetContextMock();

        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('add')
            ->willReturn($context)
        ;

        $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($context, $spinner->add($context));
    }

    protected function getWidgetContextMock(): MockObject&IWidgetContext
    {
        return $this->createMock(IWidgetContext::class);
    }

    #[Test]
    public function canRemoveWidget(): void
    {
        $context = $this->getWidgetContextMock();
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('remove')
        ;

        $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

        self::assertInstanceOf(Spinner::class, $spinner);
        $spinner->remove($context);
    }

    #[Test]
    public function throwsIfObserverAlreadyAttached(): void
    {
        $exceptionClass = InvalidArgument::class;
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

    #[Test]
    public function throwsOnAddIfRootWidgetIsNotAComposite(): void
    {
        $exceptionClass = WidgetIsNotAComposite::class;
        $exceptionMessage = 'Root widget is not a composite.';

        $test = function (): void {
            $context = $this->getWidgetContextMock();

            $rootWidget = $this->getWidgetMock();

            $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

            self::assertSame($context, $spinner->add($context));
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
