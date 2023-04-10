<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\DriverBuilder;
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
        return
            new DriverBuilder(
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock()
            );
    }

    #[Test]
    public function canBuildDriverWithCustomIntervalCallback(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $driver = $driverBuilder
            ->withDriverOutput($this->getDriverOutputMock())
            ->withTimer($this->getTimerMock())
            ->withIntervalCallback(fn() => $this->getIntervalMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
    }

    #[Test]
    public function canBuildDriverWithoutIntervalCallback(): void
    {
        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects(self::exactly(2))
            ->method('createStill')
            ->willReturn($this->getIntervalMock())
        ;

        $driverBuilder = $this->getTesteeInstance(intervalFactory: $intervalFactory);

        $driver = $driverBuilder
            ->withDriverOutput($this->getDriverOutputMock())
            ->withTimer($this->getTimerMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
    }

    #[Test]
    public function throwsIfDriverOutputIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'DriverOutput is not set.';

        $test = function () {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withTimer($this->getTimerMock())
                ->build()
            ;
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
            method: __METHOD__,
        );
    }

    #[Test]
    public function throwsIfTimerOutputIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Timer is not set.';

        $test = function () {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withDriverOutput($this->getDriverOutputMock())
                ->build()
            ;
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
            method: __METHOD__,
        );
    }

}
