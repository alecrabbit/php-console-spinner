<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);
    }

    public function getTesteeInstance(): IDriverBuilder
    {
        return
            new DriverBuilder();
    }

    #[Test]
    public function canBuildDriverWithCustomInterval(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $interval = $this->getIntervalMock();

        $driver = $driverBuilder
            ->withDriverOutput($this->getDriverOutputMock())
            ->withTimer($this->getTimerMock())
            ->withInitialInterval($interval)
            ->withDriverSettings($this->getLegacyDriverSettingsMock())
            ->withDriverConfig($this->getDriverConfigMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
        self::assertSame($interval, $driver->getInterval());
    }

    #[Test]
    public function canBuildWithObserver(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $driver = $driverBuilder
            ->withDriverOutput($this->getDriverOutputMock())
            ->withTimer($this->getTimerMock())
            ->withObserver($this->getObserverMock())
            ->withDriverSettings($this->getLegacyDriverSettingsMock())
            ->withInitialInterval($this->getIntervalMock())
            ->withDriverConfig($this->getDriverConfigMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
    }

    #[Test]
    public function throwsIfDriverOutputIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'DriverOutput is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withTimer($this->getTimerMock())
                ->withDriverSettings($this->getLegacyDriverSettingsMock())
                ->withInitialInterval($this->getIntervalMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfTimerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Timer is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withDriverOutput($this->getDriverOutputMock())
                ->withDriverSettings($this->getLegacyDriverSettingsMock())
                ->withInitialInterval($this->getIntervalMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfDriverSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'DriverSettings are not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withDriverOutput($this->getDriverOutputMock())
                ->withTimer($this->getTimerMock())
                ->withInitialInterval($this->getIntervalMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfDriverConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'DriverConfig is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withDriverOutput($this->getDriverOutputMock())
                ->withTimer($this->getTimerMock())
                ->withInitialInterval($this->getIntervalMock())
                ->withDriverSettings($this->getLegacyDriverSettingsMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    protected function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

    #[Test]
    public function throwsIfInitialIntervalIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'InitialInterval is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withDriverOutput($this->getDriverOutputMock())
                ->withTimer($this->getTimerMock())
                ->withDriverSettings($this->getLegacyDriverSettingsMock())
                ->withDriverConfig($this->getDriverConfigMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
