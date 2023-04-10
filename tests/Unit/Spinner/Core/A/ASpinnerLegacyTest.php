<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\A\ALegacySpinner;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriver;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Core\A\Override\ALegacySpinnerOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ASpinnerLegacyTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function isCreatedInactiveAndUninterrupted(): void
    {
        $spinner = $this->getTesteeInstance(driver: null, rootWidget: null);

        self::assertInstanceOf(ALegacySpinner::class, $spinner);
        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
    }

    public function getTesteeInstance(
        (MockObject&ILegacyDriver)|null $driver,
        (MockObject&IWidgetComposite)|null $rootWidget,
    ): ILegacySpinner {
        return
            new ALegacySpinnerOverride(
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
        self::assertTrue(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));

        $spinner->deactivate();
        self::assertFalse(self::getPropertyValue('active', $spinner));
    }

    #[Test]
    public function canBeInterruptedAfterCreation(): void
    {
        $spinner = $this->getTesteeInstance(driver: null, rootWidget: null);

        $spinner->interrupt();
        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
    }

    #[Test]
    public function canBeFinalizedAfterCreation(): void
    {
        $spinner = $this->getTesteeInstance(driver: null, rootWidget: null);

        $spinner->finalize();
        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
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
        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
    }

    #[Test]
    public function invokingInterruptOnUninitializedHasNoEffect(): void
    {
        $driver = $this->getDriverMock();
        $driver->expects(self::never())->method('finalize');
        $driver->expects(self::never())->method('erase');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: null);

        $spinner->interrupt();
        $spinner->finalize();
        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
    }
    #[Test]
    public function invokingInterruptOnInitializedHasEffect(): void
    {
        $driver = $this->getDriverMock();
        $driver->expects(self::never())->method('finalize');
        $driver->expects(self::once())->method('erase');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: null);

        $spinner->initialize();
        self::assertTrue(self::getPropertyValue('active', $spinner));
        $spinner->interrupt();
        $spinner->finalize();
        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertTrue(self::getPropertyValue('interrupted', $spinner));
    }

    #[Test]
    public function invokingFinalizeOnInitializedHasEffect(): void
    {
        $driver = $this->getDriverMock();
        $driver->expects(self::once())->method('finalize');
        $driver->expects(self::once())->method('erase');

        $spinner = $this->getTesteeInstance(driver: $driver, rootWidget: null);

        $spinner->initialize();
        self::assertTrue(self::getPropertyValue('active', $spinner));
        $spinner->finalize();
        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
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
        self::assertTrue(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
    }

    #[Test]
    public function canGetIntervalFromUnderlyingRootWidget(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget->expects(self::once())->method('getInterval');

        $spinner = $this->getTesteeInstance(driver: null, rootWidget: $rootWidget);

        $spinner->getInterval();
        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
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

        self::assertFalse(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));

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

        self::assertTrue(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));
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

        self::assertTrue(self::getPropertyValue('active', $spinner));
        self::assertFalse(self::getPropertyValue('interrupted', $spinner));

        $spinner->remove($context);
    }
}
