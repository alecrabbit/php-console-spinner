<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;


use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDisabledDriverDetector;
use AlecRabbit\Spinner\Core\DisabledDriverDetector;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

class DisabledDriverDetectorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(DisabledDriverDetector::class, $detector);
    }

    private function getTesteeInstance(
        ?IDriverConfig $driverConfig = null,
    ): IDisabledDriverDetector
    {
        return new DisabledDriverDetector(
            driverConfig: $driverConfig ?? $this->getDriverConfigMock(),
        );
    }

    #[Test]
    public function canDetectIsDisabled(): void
    {
        $driverConfig = $this->getDriverConfigMock(
            linkerMode: DriverMode::DISABLED,
        );

        $detector = $this->getTesteeInstance(
            driverConfig: $driverConfig,
        );

        self::assertTrue($detector->isDisabled($driverConfig));
    }
    #[Test]
    public function canDetectIsEnabled(): void
    {
        $driverConfig = $this->getDriverConfigMock(
            linkerMode: DriverMode::ENABLED,
        );

        $detector = $this->getTesteeInstance(
            driverConfig: $driverConfig,
        );

        self::assertFalse($detector->isDisabled());
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
}
