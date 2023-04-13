<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
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
        ?IWidgetComposite $rootWidget = null,
    ): ISpinner {
        return
            new Spinner(
                $rootWidget ?? $this->getWidgetCompositeMock(),
            );
    }

    #[Test]
    public function canUpdate(): void
    {
        $frame = $this->getFrameMock();
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('update')
            ->willReturn($frame)
        ;
        $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($frame, $spinner->update());
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

}
