<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\DriverProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverProviderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverProvider = $this->getTesteeInstance();

        self::assertInstanceOf(DriverProvider::class, $driverProvider);
    }

    public function getTesteeInstance(?IDriver $driver = null): IDriverProvider
    {
        return
            new DriverProvider(
                driver: $driver ?? $this->getDriverMock(),
            );
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    #[Test]
    public function canGetDriver(): void
    {
        $driver = $this->getDriverMock();

        $driverProvider = $this->getTesteeInstance(
            driver: $driver,
        );

        self::assertSame($driver, $driverProvider->getDriver());
    }
}
