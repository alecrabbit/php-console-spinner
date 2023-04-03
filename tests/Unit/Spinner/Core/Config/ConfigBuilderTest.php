<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class ConfigBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);
    }

    public function getTesteeInstance(
        ?IDefaultsProvider $defaultsProvider = null,
    ): IConfigBuilder {
        return
            new ConfigBuilder(
                defaultsProvider: $defaultsProvider ?? new DefaultsProvider(),
            );
    }

    #[Test]
    public function canBuildDefaultConfig(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $config = $configBuilder->build();
    }

    #[Test]
    public function canBuildWithDriverConfig(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $driverConfig = new DriverConfig('interrupted', 'finished');

        $config = $configBuilder->withDriverConfig($driverConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

    #[Test]
    public function canBuildWithLoopConfig(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $loopConfig =
            new LoopConfig(
                OptionRunMode::SYNCHRONOUS,
                OptionAutoStart::DISABLED,
                OptionSignalHandlers::DISABLED,
            );

        $config = $configBuilder->withLoopConfig($loopConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

    #[Test]
    public function canBuildWithSpinnerConfig(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $spinnerConfig =
            new SpinnerConfig(
                OptionInitialization::DISABLED,
            );

        $config = $configBuilder->withSpinnerConfig($spinnerConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

    #[Test]
    public function canBuildWithRootWidgetConfig(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $widgetConfig = $this->getWidgetConfigMock();

        $config = $configBuilder->withRootWidgetConfig($widgetConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

    #[Test]
    public function canBuildWithAuxConfig(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $auxConfig = $this->getAuxConfigMock();

        $config = $configBuilder->withAuxConfig($auxConfig)->build();

        self::assertInstanceOf(Config::class, $config);
    }

}
