<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Factory\DriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverMessagesSolver;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
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
        ?IDriverMessagesSolver $driverMessagesSolver = null,
    ): IDriverConfigFactory {
        return
            new DriverConfigFactory(
                driverConfigBuilder: $driverConfigBuilder ?? $this->getDriverConfigBuilderMock(),
                driverMessagesSolver: $driverMessagesSolver ?? $this->getDriverMessagesSolverMock(),
            );
    }


    protected function getDriverConfigBuilderMock(): MockObject&IDriverConfigBuilder
    {
        return $this->createMock(IDriverConfigBuilder::class);
    }

    private function getDriverMessagesSolverMock(): MockObject&IDriverMessagesSolver
    {
        return $this->createMock(IDriverMessagesSolver::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $driverMessages = $this->getDriverMessagesMock();
        $driverConfig = $this->geyDriverConfigMock();
        $driverMessagesSolver = $this->getDriverMessagesSolverMock();
        $driverMessagesSolver
            ->expects(self::once())
            ->method('solve')
            ->willReturn($driverMessages)
        ;
        $driverConfigBuilder = $this->getDriverConfigBuilderMock();
        $driverConfigBuilder
            ->expects(self::once())
            ->method('withDriverMessages')
            ->willReturnSelf()
        ;
        $driverConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driverConfig)
        ;

        $factory = $this->getTesteeInstance(
            driverConfigBuilder: $driverConfigBuilder,
            driverMessagesSolver: $driverMessagesSolver,
        );

        self::assertSame($driverConfig, $factory->create());
    }

    private function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }

    private function geyDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

}
