<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Detector;


use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\ILinkerModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Config\Detector\LinkerModeDetector;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LinkerModeDetectorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(LinkerModeDetector::class, $detector);
    }

    private function getTesteeInstance(
        ?ILinkerConfig $linkerConfig = null,
    ): ILinkerModeDetector {
        return new LinkerModeDetector(
            linkerConfig: $linkerConfig ?? $this->getLinkerConfigMock(),
        );
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

    #[Test]
    public function canDetectWhenDisabled(): void
    {
        $linkerConfig = $this->getLinkerConfigMock(
            linkerMode: LinkerMode::DISABLED,
        );

        $detector = $this->getTesteeInstance(
            linkerConfig: $linkerConfig,
        );

        self::assertFalse($detector->isEnabled());
    }

    #[Test]
    public function canDetectWhenEnabled(): void
    {
        $linkerConfig = $this->getLinkerConfigMock(
            linkerMode: LinkerMode::ENABLED,
        );

        $detector = $this->getTesteeInstance(
            linkerConfig: $linkerConfig,
        );

        self::assertTrue($detector->isEnabled());
    }
}
