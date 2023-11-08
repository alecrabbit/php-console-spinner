<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILinkerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Config\Factory\LinkerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILinkerModeSolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LinkerConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(LinkerConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?ILinkerModeSolver $linkerModeSolver = null,
        ?ILinkerConfigBuilder $linkerConfigBuilder = null,
    ): ILinkerConfigFactory {
        return
            new LinkerConfigFactory(
                linkerModeSolver: $linkerModeSolver ?? $this->getLinkerModeSolverMock(),
                linkerConfigBuilder: $linkerConfigBuilder ?? $this->getLinkerConfigBuilderMock(),
            );
    }

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


    protected function getLinkerConfigBuilderMock(): MockObject&ILinkerConfigBuilder
    {
        return $this->createMock(ILinkerConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $linkerMode = LinkerMode::ENABLED;

        $linkerConfig =
            $this->getLinkerConfigMock(
                $linkerMode,
            );

        $linkerConfigBuilder = $this->getLinkerConfigBuilderMock();
        $linkerConfigBuilder
            ->expects(self::once())
            ->method('withLinkerMode')
            ->with($linkerMode)
            ->willReturnSelf()
        ;
        $linkerConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($linkerConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                linkerModeSolver: $this->getLinkerModeSolverMock($linkerMode),
                linkerConfigBuilder: $linkerConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($linkerConfig, $config);

        self::assertSame($linkerMode, $config->getLinkerMode());
    }

    protected function getLinkerConfigMock(
        ?LinkerMode $linkerMode = null,
    ): MockObject&ILinkerConfig {
        return
            $this->createConfiguredMock(
                ILinkerConfig::class,
                [
                    'getLinkerMode' => $linkerMode ?? LinkerMode::DISABLED,
                ]
            );
    }
}
