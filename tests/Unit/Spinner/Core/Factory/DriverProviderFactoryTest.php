<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Core\Factory\DriverProviderFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverProviderFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverProviderFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IDriverFactory $driverFactory = null,
    ): IDriverProviderFactory {
        return
            new DriverProviderFactory(
                driverFactory: $driverFactory ?? $this->getDriverFactoryMock(),
            );
    }

    private function getDriverFactoryMock(): MockObject&IDriverFactory
    {
        return $this->createMock(IDriverFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $driver = $this->getDriverMock();

        $driverFactory = $this->getDriverFactoryMock();
        $driverFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($driver)
        ;

        $factory =
            $this->getTesteeInstance(
                driverFactory: $driverFactory
            );

        $driverProvider = $factory->create();

        self::assertSame($driver, $driverProvider->getDriver());
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }
}
