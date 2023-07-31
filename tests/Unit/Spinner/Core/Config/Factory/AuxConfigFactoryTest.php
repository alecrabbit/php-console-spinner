<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\ILoopAvailabilityModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\INormalizerMethodModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IRunMethodModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\AuxConfigFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AuxConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(AuxConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IRunMethodModeDetector $runMethodDetector = null,
        ?ILoopAvailabilityModeDetector $loopAvailabilityDetector = null,
        ?INormalizerMethodModeDetector $normalizerMethodDetector = null,
    ): IAuxConfigFactory {
        return
            new AuxConfigFactory(
                runMethodModeDetector: $runMethodDetector ?? $this->getRunMethodModeDetectorMock(),
                loopAvailabilityModeDetector: $loopAvailabilityDetector ?? $this->getLoopAvailabilityModeDetectorMock(),
                normalizerMethodModeDetector: $normalizerMethodDetector ?? $this->getNormalizerMethodModeDetectorMock(),
            );
    }

    protected function getRunMethodModeDetectorMock(?RunMethodMode $runMethodMode = null
    ): MockObject&IRunMethodModeDetector {
        return
            $this->createConfiguredMock(
                IRunMethodModeDetector::class,
                [
                    'detect' => $runMethodMode ?? RunMethodMode::SYNCHRONOUS,
                ]
            );
    }

    protected function getLoopAvailabilityModeDetectorMock(?LoopAvailabilityMode $loopAvailabilityMode = null
    ): MockObject&ILoopAvailabilityModeDetector {
        return
            $this->createConfiguredMock(
                ILoopAvailabilityModeDetector::class,
                [
                    'detect' => $loopAvailabilityMode ?? LoopAvailabilityMode::NONE,
                ]
            );
    }

    protected function getNormalizerMethodModeDetectorMock(?NormalizerMethodMode $normalizerMethodMode = null
    ): MockObject&INormalizerMethodModeDetector {
        return
            $this->createConfiguredMock(
                INormalizerMethodModeDetector::class,
                [
                    'detect' => $normalizerMethodMode ?? NormalizerMethodMode::STILL,
                ]
            );
    }

    #[Test]
    public function canCreate(): void
    {
        $runMethodMode = RunMethodMode::ASYNC;
        $loopAvailabilityMode = LoopAvailabilityMode::AVAILABLE;
        $normalizerMethodMode = NormalizerMethodMode::BALANCED;

        $factory =
            $this->getTesteeInstance(
                runMethodDetector: $this->getRunMethodModeDetectorMock($runMethodMode),
                loopAvailabilityDetector: $this->getLoopAvailabilityModeDetectorMock($loopAvailabilityMode),
                normalizerMethodDetector: $this->getNormalizerMethodModeDetectorMock($normalizerMethodMode),
            );

        $config = $factory->create();

        self::assertInstanceOf(AuxConfig::class, $config);

        self::assertSame($runMethodMode, $config->getRunMethodMode());
        self::assertSame($loopAvailabilityMode, $config->getLoopAvailabilityMode());
        self::assertSame($normalizerMethodMode, $config->getNormalizerMethodMode());
    }
}
