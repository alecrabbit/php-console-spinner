<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Factory\DriverConfigFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IDriverConfigBuilder $driverConfigBuilder = null,
    ): IDriverConfigFactory {
        return
            new DriverConfigFactory(
                driverConfigBuilder: $driverConfigBuilder ?? $this->getDriverConfigBuilderMock(),
            );
    }


    protected function getDriverConfigBuilderMock(): MockObject&IDriverConfigBuilder
    {
        return $this->createMock(IDriverConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $driverConfig = $this->geyDriverConfigMock();
        $driverConfigBuilder = $this->getDriverConfigBuilderMock();
        $driverConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driverConfig)
        ;

        $factory = $this->getTesteeInstance(
            driverConfigBuilder: $driverConfigBuilder,
        );

        self::assertSame($driverConfig, $factory->create());
    }

    private function geyDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }
}
