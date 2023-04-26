<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinner = $this->getTesteeInstance();

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    protected function getTesteeInstance(
        ?IWidget $rootWidget = null,
        ?IObserver $observer = null,
    ): ISpinner {
        return new Spinner(
            rootWidget: $rootWidget ?? $this->getWidgetMock(),
            observer: $observer,
        );
    }

    #[Test]
    public function canUpdate(): void
    {
        $frame = $this->getFrameMock();
        $rootWidget = $this->getWidgetMock();
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
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $rootWidget = $this->getWidgetMock();
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
        $widget = $this->getWidgetMock();

        $rootWidget = $this->getWidgetMock();
        $rootWidget
            ->expects(self::once())
            ->method('add')
            ->willReturn($context)
        ;
        $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($context, $spinner->add($widget));
    }

    #[Test]
    public function canRemoveWidget(): void
    {
        $widget = $this->getWidgetMock();
        $rootWidget = $this->getWidgetMock();
        $rootWidget
            ->expects(self::once())
            ->method('remove')
        ;
        $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

        self::assertInstanceOf(Spinner::class, $spinner);
        $spinner->remove($widget);
    }
}
