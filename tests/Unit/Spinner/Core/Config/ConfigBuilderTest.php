<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Contract\OptionAttach;
use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\AuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\LoopSettings;
use AlecRabbit\Spinner\Core\Defaults\SpinnerSettings;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Snake;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\A\AStylePattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

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
                defaultsProvider: $defaultsProvider ?? $this->getDefaultsProviderMock(),
            );
    }

    protected function getDefaultsProviderMock(): MockObject&IDefaultsProvider
    {
        $defaultsProvider = parent::getDefaultsProviderMock();
        $defaultsProvider
            ->method('getLoopSettings')
            ->willReturn(
                new LoopSettings(
                    OptionRunMode::SYNCHRONOUS,
                    OptionAutoStart::DISABLED,
                    OptionSignalHandlers::DISABLED,
                ),
            )
        ;
        $defaultsProvider
            ->method('getSpinnerSettings')
            ->willReturn(
                new SpinnerSettings(
                    OptionInitialization::DISABLED,
                    OptionAttach::DISABLED,
                ),
            )
        ;
        $defaultsProvider
            ->method('getAuxSettings')
            ->willReturn(
                new AuxSettings(
                    new Interval(1000),
                    NormalizerMode::BALANCED,
                    OptionCursor::HIDDEN,
                    OptionStyleMode::ANSI8,
                    STDERR
                ),
            )
        ;
        $defaultsProvider
            ->method('getDriverSettings')
            ->willReturn(
                $this->getDriverSettingsMock(),
            )
        ;
        $defaultsProvider
            ->method('getRootWidgetSettings')
            ->willReturn(
                $this->getWidgetSettingsMock(),
            )
        ;
        $defaultsProvider
            ->method('getWidgetSettings')
            ->willReturn(
                $this->getWidgetSettingsMock(),
            )
        ;
        return $defaultsProvider;
    }

    protected function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        $widgetSettings = parent::getWidgetSettingsMock();
        $widgetSettings
            ->method('getStylePattern')
            ->willReturn(new class() extends AStylePattern {})
        ;
        $widgetSettings
            ->method('getCharPattern')
            ->willReturn(new class() extends APattern {})
        ;
        return $widgetSettings;
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
                OptionAttach::DISABLED,
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
