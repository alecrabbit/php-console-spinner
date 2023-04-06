<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Core\A\Override\ASpinnerOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ASpinnerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function isCreatedInactiveAndUninterrupted(): void
    {
        $spinner = $this->getTesteeInstance(driver: null, rootWidget: null);

        self::assertInstanceOf(ASpinner::class, $spinner);
        self::assertFalse(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));
    }

    public function getTesteeInstance(
        (MockObject&IDriver)|null $driver,
        (MockObject&IWidgetComposite)|null $rootWidget,
    ): ISpinner {
        return
            new ASpinnerOverride(
                driver: $driver ?? $this->getDriverMock(),
                rootWidget: $rootWidget ?? $this->getWidgetCompositeMock(),
            );
    }

    #[Test]
    public function canBeInitializedAfterCreation(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget->expects(self::once())->method('update');

        $spinner = $this->getTesteeInstance(driver: null, rootWidget: $rootWidget);

        $spinner->initialize();
        self::assertTrue(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));

        $spinner->deactivate();
        self::assertFalse(self::getValue('active', $spinner));
    }

    #[Test]
    public function canBeInterruptedAfterCreation(): void
    {
        $spinner = $this->getTesteeInstance(driver: null, rootWidget: null);

        $spinner->interrupt();
        self::assertFalse(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));
    }

    #[Test]
    public function canBeFinalizedAfterCreation(): void
    {
        $spinner = $this->getTesteeInstance(driver: null, rootWidget: null);

        $spinner->finalize();
        self::assertFalse(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));
    }

    #[Test]
    public function invokingSpinOnUninitializedHasNoEffect(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget->expects(self::never())->method('update');

        $driver = $this->getDriverMock();
        $driver->expects(self::never())->method('display');
        $driver->expects(self::once())->method('elapsedTime');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: $rootWidget);

        $spinner->spin();
        self::assertFalse(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));
    }

    #[Test]
    public function invokingFinalizeOnInterruptedHasNoEffect(): void
    {
        $driver = $this->getDriverMock();
        $driver->expects(self::never())->method('finalize');
        $driver->expects(self::never())->method('erase');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: null);

        $spinner->interrupt();
        $spinner->finalize();
        self::assertFalse(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));
    }

    #[Test]
    public function invokingSpinOnInitializedHasEffect(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget->expects(self::exactly(2))->method('update');

        $driver = $this->getDriverMock();
        $driver->expects(self::once())->method('display');
        $driver->expects(self::once())->method('elapsedTime');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: $rootWidget);

        $spinner->initialize();
        $spinner->spin();
        self::assertTrue(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));
    }

    #[Test]
    public function canGetIntervalFromUnderlyingRootWidget(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget->expects(self::once())->method('getInterval');

        $spinner = $this->getTesteeInstance(driver: null, rootWidget: $rootWidget);

        $spinner->getInterval();
        self::assertFalse(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));
    }

    #[Test]
    public function canWrapCallableUninitialized(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget->expects(self::never())->method('update');

        $driver = $this->getDriverMock();
        $driver->expects(self::never())->method('display');
        $driver->expects(self::once())->method('elapsedTime');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: $rootWidget);

        $func = static function () use (&$result) {
            return $result = 42;
        };

        $spinner->wrap($func);

        self::assertFalse(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));

        self::assertEquals(42, $result);
    }

    #[Test]
    public function canAddWidgetsToRootWidget(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget->expects(self::once())->method('add');
        $rootWidget->expects(self::exactly(2))->method('update');

        $driver = $this->getDriverMock();
        $driver->expects(self::once())->method('erase');
        $driver->expects(self::once())->method('display');
        $driver->expects(self::once())->method('elapsedTime');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: $rootWidget);

        $spinner->initialize();
        $spinner->add($this->getWidgetCompositeMock());

        self::assertTrue(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));
    }

    #[Test]
    public function canRemoveWidgetsFromRootWidget(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget->expects(self::once())->method('add');
        $rootWidget->expects(self::once())->method('remove');
        $rootWidget->expects(self::exactly(3))->method('update');

        $driver = $this->getDriverMock();
        $driver->expects(self::exactly(2))->method('erase');
        $driver->expects(self::exactly(2))->method('display');
        $driver->expects(self::exactly(2))->method('elapsedTime');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: $rootWidget);

        $spinner->initialize();
        $context = $spinner->add($this->getWidgetCompositeMock());

        self::assertTrue(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));

        $spinner->remove($context);
    }
}
