<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;


use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Detector\DriverModeDetector;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverModeDetectorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(DriverModeDetector::class, $detector);
    }

    private function getTesteeInstance(
        ?IDriverConfig $driverConfig = null,
    ): IDriverModeDetector {
        return new DriverModeDetector(
            driverConfig: $driverConfig ?? $this->getDriverConfigMock(),
        );
    }

    protected function getDriverConfigMock(
        ?DriverMode $linkerMode = null,
    ): MockObject&IDriverConfig {
        return
            $this->createConfiguredMock(
                IDriverConfig::class,
                [
                    'getDriverMode' => $linkerMode ?? DriverMode::DISABLED,
                ]
            );
    }

    #[Test]
    public function canDetectWhenDisabled(): void
    {
        $driverConfig = $this->getDriverConfigMock(
            linkerMode: DriverMode::DISABLED,
        );

        $detector = $this->getTesteeInstance(
            driverConfig: $driverConfig,
        );

        self::assertFalse($detector->isEnabled());
    }

    #[Test]
    public function canDetectWhenEnabled(): void
    {
        $driverConfig = $this->getDriverConfigMock(
            linkerMode: DriverMode::ENABLED,
        );

        $detector = $this->getTesteeInstance(
            driverConfig: $driverConfig,
        );

        self::assertTrue($detector->isEnabled());
    }
}
