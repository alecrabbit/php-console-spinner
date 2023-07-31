<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DriverConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(DriverConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?LinkerMode $linkerMode = null,
        ?InitializationMode $initializationMode = null,
    ): IDriverConfig {
        return
            new DriverConfig(
                linkerMode: $linkerMode ?? LinkerMode::DISABLED,
                initializationMode: $initializationMode ?? InitializationMode::DISABLED,
            );
    }

    #[Test]
    public function canGetLinkerMode(): void
    {
        $linkerMode = LinkerMode::ENABLED;

        $config = $this->getTesteeInstance(
            linkerMode: $linkerMode,
        );

        self::assertSame($linkerMode, $config->getLinkerMode());
    }

    #[Test]
    public function canGetInitializationMode(): void
    {
        $initializationMode = InitializationMode::ENABLED;

        $config = $this->getTesteeInstance(
            initializationMode: $initializationMode,
        );

        self::assertSame($initializationMode, $config->getInitializationMode());
    }

}
