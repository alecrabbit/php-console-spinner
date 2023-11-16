<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\INormalizerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\INormalizerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Core\Config\Factory\NormalizerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NormalizerConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(NormalizerConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?INormalizerModeSolver $normalizerModeSolver = null,
        ?INormalizerConfigBuilder $normalizerConfigBuilder = null,
    ): INormalizerConfigFactory {
        return
            new NormalizerConfigFactory(
                normalizerModeSolver: $normalizerModeSolver ?? $this->getNormalizerModeSolverMock(),
                normalizerConfigBuilder: $normalizerConfigBuilder ?? $this->getNormalizerConfigBuilderMock(),
            );
    }

    protected function getRunMethodModeSolverMock(?RunMethodMode $runMethodMode = null
    ): MockObject&IRunMethodModeSolver {
        return
            $this->createConfiguredMock(
                IRunMethodModeSolver::class,
                [
                    'solve' => $runMethodMode ?? RunMethodMode::SYNCHRONOUS,
                ]
            );
    }

    protected function getNormalizerModeSolverMock(?NormalizerMode $normalizerMode = null
    ): MockObject&INormalizerModeSolver {
        return
            $this->createConfiguredMock(
                INormalizerModeSolver::class,
                [
                    'solve' => $normalizerMode ?? NormalizerMode::STILL,
                ]
            );
    }

    protected function getNormalizerConfigBuilderMock(): MockObject&INormalizerConfigBuilder
    {
        return $this->createMock(INormalizerConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $normalizerMode = NormalizerMode::BALANCED;

        $normalizerConfig =
            $this->getNormalizerConfigMock(
                $normalizerMode
            );

        $normalizerConfigBuilder = $this->getNormalizerConfigBuilderMock();
        $normalizerConfigBuilder
            ->expects(self::once())
            ->method('withNormalizerMode')
            ->with($normalizerMode)
            ->willReturnSelf()
        ;
        $normalizerConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($normalizerConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                normalizerModeSolver: $this->getNormalizerModeSolverMock($normalizerMode),
                normalizerConfigBuilder: $normalizerConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($normalizerConfig, $config);

        self::assertSame($normalizerMode, $config->getNormalizerMode());
    }

    private function getNormalizerConfigMock(
        NormalizerMode $normalizerMode,
    ): MockObject&INormalizerConfig {
        return
            $this->createConfiguredMock(
                INormalizerConfig::class,
                [
                    'getNormalizerMode' => $normalizerMode,
                ]
            );
    }
}
