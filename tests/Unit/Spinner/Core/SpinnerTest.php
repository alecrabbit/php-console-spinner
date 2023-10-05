<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\WidgetIsNotAComposite;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerTest extends TestCaseWithPrebuiltMocksAndStubs
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
        $exceptionClass = InvalidArgumentException::class;
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
        $exceptionClass = InvalidArgumentException::class;
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
        $exceptionMessage = 'Widget is not a composite.';

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
