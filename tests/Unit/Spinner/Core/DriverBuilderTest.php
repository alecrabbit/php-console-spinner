<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);
    }

    public function getTesteeInstance(
        ?IIntervalFactory $intervalFactory = null,
    ): IDriverBuilder {
        return new DriverBuilder(
            intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock()
        );
    }

    #[Test]
    public function canBuildDriverWithCustomIntervalCallback(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $interval = $this->getIntervalMock();
        $driver = $driverBuilder
            ->withDriverOutput($this->getDriverOutputMock())
            ->withTimer($this->getTimerMock())
            ->withInitialInterval($interval)
            ->withDriverSettings($this->getDriverSettingsMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
        self::assertSame($interval, $driver->getInterval());
    }

    #[Test]
    public function canBuildDriverWithoutIntervalCallback(): void
    {
        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects(self::once())
            ->method('createStill')
            ->willReturn($this->getIntervalMock())
        ;

        $driverBuilder = $this->getTesteeInstance(intervalFactory: $intervalFactory);

        $driver = $driverBuilder
            ->withDriverOutput($this->getDriverOutputMock())
            ->withTimer($this->getTimerMock())
            ->withDriverSettings($this->getDriverSettingsMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
    }

    #[Test]
    public function canBuildWithObserver(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $driver = $driverBuilder
            ->withDriverOutput($this->getDriverOutputMock())
            ->withTimer($this->getTimerMock())
            ->withObserver($this->getObserverMock())
            ->withDriverSettings($this->getDriverSettingsMock())
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
                ->withDriverSettings($this->getDriverSettingsMock())
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
                ->withDriverSettings($this->getDriverSettingsMock())
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
