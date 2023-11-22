<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;


use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IInitializationModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Detector\InitializationModeDetector;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class InitializationModeDetectorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(InitializationModeDetector::class, $detector);
    }

    private function getTesteeInstance(
        ?IOutputConfig $outputConfig = null,
    ): IInitializationModeDetector {
        return new InitializationModeDetector(
            outputConfig: $outputConfig ?? $this->getOutputConfigMock(),
        );
    }

    protected function getOutputConfigMock(
        ?InitializationMode $initializationMode = null,
    ): MockObject&IOutputConfig {
        return
            $this->createConfiguredMock(
                IOutputConfig::class,
                [
                    'getInitializationMode' => $initializationMode ?? InitializationMode::DISABLED,
                ]
            );
    }

    #[Test]
    public function canDetectWhenDisabled(): void
    {
        $linkerConfig = $this->getOutputConfigMock(
            initializationMode: InitializationMode::DISABLED,
        );

        $detector = $this->getTesteeInstance(
            outputConfig: $linkerConfig,
        );

        self::assertFalse($detector->isEnabled());
    }

    #[Test]
    public function canDetectWhenEnabled(): void
    {
        $linkerConfig = $this->getOutputConfigMock(
            initializationMode: InitializationMode::ENABLED,
        );

        $detector = $this->getTesteeInstance(
            outputConfig: $linkerConfig,
        );

        self::assertTrue($detector->isEnabled());
    }
}
