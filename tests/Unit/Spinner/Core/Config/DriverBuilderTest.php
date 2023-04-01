<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\DriverBuilder;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

final class DriverBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverBuilder::class, $configBuilder);
    }

    public function getTesteeInstance(
        ?IDefaultsProvider $defaultsProvider = null,
    ): IDriverBuilder {
        return
            new DriverBuilder(
                defaultsProvider: $defaultsProvider ?? new DefaultsProvider(),
            );
    }

    #[Test]
    public function canBuildDriverWithDriverConfig(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);

        $driverConfig = new DriverConfig('interrupted', 'finished');
        $driver = $driverBuilder->withDriverConfig($driverConfig)->build();

        self::assertInstanceOf(Driver::class, $driver);
    }

    #[Test]
    public function throwsOnBuildDriverWithoutDriverConfig(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);

        $exceptionClass = LogicException::class;
        $exceptionMessage = '[AlecRabbit\Spinner\Core\Config\DriverBuilder]: Property $driverConfig is not set.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $driver = $driverBuilder->build();

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

}
