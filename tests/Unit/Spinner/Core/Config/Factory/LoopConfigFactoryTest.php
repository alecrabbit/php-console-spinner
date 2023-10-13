<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Factory\LoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersModeSolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IAutoStartModeSolver $autoStartModeSolver = null,
        ?ISignalHandlersModeSolver $signalHandlersModeSolver = null,
        ?ILoopConfigBuilder $loopConfigBuilder = null,
    ): ILoopConfigFactory {
        return
            new LoopConfigFactory(
                autoStartModeSolver: $autoStartModeSolver ?? $this->getAutoStartModeSolverMock(),
                signalHandlersModeSolver: $signalHandlersModeSolver ?? $this->getSignalHandlersModeSolverMock(),
                loopConfigBuilder: $loopConfigBuilder ?? $this->getLoopConfigBuilderMock(),
            );
    }

    protected function getAutoStartModeSolverMock(
        ?AutoStartMode $autoStartMode = null,
    ): MockObject&IAutoStartModeSolver {
        return
            $this->createConfiguredMock(
                IAutoStartModeSolver::class,
                [
                    'solve' => $autoStartMode ?? AutoStartMode::DISABLED,
                ]
            );
    }

    protected function getSignalHandlersModeSolverMock(
        ?SignalHandlersMode $signalHandlersMode = null,
    ): MockObject&ISignalHandlersModeSolver {
        return
            $this->createConfiguredMock(
                ISignalHandlersModeSolver::class,
                [
                    'solve' => $signalHandlersMode ?? SignalHandlersMode::DISABLED,
                ]
            );
    }

    protected function getLoopConfigBuilderMock(): MockObject&ILoopConfigBuilder
    {
        return $this->createMock(ILoopConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $autoStartMode = AutoStartMode::ENABLED;
        $signalHandlersMode = SignalHandlersMode::ENABLED;

        $loopConfig =
            $this->getLoopConfigMock(
                $autoStartMode,
                $signalHandlersMode
            );

        $loopConfigBuilder = $this->getLoopConfigBuilderMock();
        $loopConfigBuilder
            ->expects(self::once())
            ->method('withAutoStartMode')
            ->with($autoStartMode)
            ->willReturnSelf()
        ;
        $loopConfigBuilder
            ->expects(self::once())
            ->method('withSignalHandlersMode')
            ->with($signalHandlersMode)
            ->willReturnSelf()
        ;
        $loopConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($loopConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                autoStartModeSolver: $this->getAutoStartModeSolverMock($autoStartMode),
                signalHandlersModeSolver: $this->getSignalHandlersModeSolverMock($signalHandlersMode),
                loopConfigBuilder: $loopConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($loopConfig, $config);

        self::assertSame($autoStartMode, $config->getAutoStartMode());
        self::assertSame($signalHandlersMode, $config->getSignalHandlersMode());
    }

    protected function getLoopConfigMock(
        AutoStartMode $autoStartMode,
        SignalHandlersMode $signalHandlersMode,
    ): MockObject&ILoopConfig {
        return
            $this->createConfiguredMock(
                ILoopConfig::class,
                [
                    'getAutoStartMode' => $autoStartMode ?? AutoStartMode::DISABLED,
                    'getSignalHandlersMode' => $signalHandlersMode ?? SignalHandlersMode::DISABLED,
                ]
            );
    }
}
