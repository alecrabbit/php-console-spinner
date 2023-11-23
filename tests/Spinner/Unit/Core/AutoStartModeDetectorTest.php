<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;


use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IAutoStartModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Detector\AutoStartModeDetector;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AutoStartModeDetectorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(AutoStartModeDetector::class, $detector);
    }

    private function getTesteeInstance(
        ?ILoopConfig $loopConfig = null,
    ): IAutoStartModeDetector {
        return new AutoStartModeDetector(
            loopConfig: $loopConfig ?? $this->getLoopConfigMock(),
        );
    }

    protected function getLoopConfigMock(
        ?AutoStartMode $autoStartMode = null,
    ): MockObject&ILoopConfig {
        return
            $this->createConfiguredMock(
                ILoopConfig::class,
                [
                    'getAutoStartMode' => $autoStartMode ?? AutoStartMode::DISABLED,
                ]
            );
    }

    #[Test]
    public function canDetectWhenDisabled(): void
    {
        $loopConfig = $this->getLoopConfigMock(
            autoStartMode: AutoStartMode::DISABLED,
        );

        $detector = $this->getTesteeInstance(
            loopConfig: $loopConfig,
        );

        self::assertFalse($detector->isEnabled());
    }

    #[Test]
    public function canDetectWhenEnabled(): void
    {
        $loopConfig = $this->getLoopConfigMock(
            autoStartMode: AutoStartMode::ENABLED,
        );

        $detector = $this->getTesteeInstance(
            loopConfig: $loopConfig,
        );

        self::assertTrue($detector->isEnabled());
    }
}
