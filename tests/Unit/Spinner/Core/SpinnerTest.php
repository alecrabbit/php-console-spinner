<?php

declare(strict_types=1);

namespace Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ISpinner;
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

    public function getTesteeInstance(
        ?IWidgetComposite $rootWidget = null,
    ): ISpinner {
        return
            new Spinner(
                rootWidget: $rootWidget ?? $this->getWidgetCompositeMock(),
            );
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

        $spinner =
            $this->getTesteeInstance(
                rootWidget: $rootWidget
            );

        self::assertSame($interval, $spinner->getInterval());
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

        $spinner =
            $this->getTesteeInstance(
                rootWidget: $rootWidget
            );

        self::assertSame($frame, $spinner->update());
    }
}
