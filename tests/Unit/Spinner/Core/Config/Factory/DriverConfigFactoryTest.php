<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Factory\DriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IInitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILinkerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
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
        ?ILinkerModeSolver $linkerModeSolver= null,
        ?IInitializationModeSolver $initializationModeSolver= null,
        ?IDriverConfigBuilder $driverConfigBuilder = null,
    ): IDriverConfigFactory {
        return
            new DriverConfigFactory(
                linkerModeSolver: $linkerModeSolver ?? $this->getLinkerModeSolverMock(),
                initializationModeSolver: $initializationModeSolver ?? $this->getInitializationModeSolverMock(),
                driverConfigBuilder: $driverConfigBuilder ?? $this->getDriverConfigBuilderMock(),
            );
    }

//

    protected function getLinkerModeSolverMock(
        ?LinkerMode $linkerMode = null,
    ): MockObject&ILinkerModeSolver {
        return
            $this->createConfiguredMock(
                ILinkerModeSolver::class,
                [
                    'solve' => $linkerMode ?? LinkerMode::DISABLED,
                ]
            );
    }

    protected function getInitializationModeSolverMock(
        ?InitializationMode $initializationMode = null,
    ): MockObject&IInitializationModeSolver {
        return
            $this->createConfiguredMock(
                IInitializationModeSolver::class,
                [
                    'solve' => $initializationMode ?? InitializationMode::DISABLED,
                ]
            );
    }

    protected function getDriverConfigBuilderMock(): MockObject&IDriverConfigBuilder
    {
        return $this->createMock(IDriverConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $linkerMode = LinkerMode::ENABLED;
        $initializationMode = InitializationMode::ENABLED;

        $driverConfig =
            $this->getDriverConfigMock(
                $linkerMode,
                $initializationMode
            );

        $outputConfigBuilder = $this->getDriverConfigBuilderMock();
        $outputConfigBuilder
            ->expects(self::once())
            ->method('withLinkerMode')
            ->with($linkerMode)
            ->willReturnSelf()
        ;
        $outputConfigBuilder
            ->expects(self::once())
            ->method('withInitializationMode')
            ->with($initializationMode)
            ->willReturnSelf()
        ;
        $outputConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driverConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                linkerModeSolver: $this->getLinkerModeSolverMock($linkerMode),
                initializationModeSolver: $this->getInitializationModeSolverMock($initializationMode),
                driverConfigBuilder: $outputConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($driverConfig, $config);

        self::assertSame($linkerMode, $config->getLinkerMode());
        self::assertSame($initializationMode, $config->getInitializationMode());
    }

    protected function getDriverConfigMock(
        ?LinkerMode $linkerMode = null,
        ?InitializationMode $initializationMode = null,
    ): MockObject&IDriverConfig {
        return
            $this->createConfiguredMock(
                IDriverConfig::class,
                [
                    'getLinkerMode' => $linkerMode ?? LinkerMode::DISABLED,
                    'getInitializationMode' => $initializationMode ?? InitializationMode::DISABLED,
                ]
            );
    }
}
