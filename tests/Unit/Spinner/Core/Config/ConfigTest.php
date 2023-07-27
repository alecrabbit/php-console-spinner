<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(Config::class, $config);
    }

    protected function getTesteeInstance(
        ?IAuxConfig $auxConfig = null,
        ?ILoopConfig $loopConfig = null,
        ?IOutputConfig $outputConfig = null,
        ?IDriverConfig $driverConfig = null,
        ?IWidgetConfig $widgetConfig = null,
        ?IWidgetConfig $rootWidgetConfig = null,
    ): IConfig {
        return
            new Config(
                auxConfig: $auxConfig ?? $this->getAuxConfigMock(),
                loopConfig: $loopConfig ?? $this->getLoopConfigMock(),
                outputConfig: $outputConfig ?? $this->getOutputConfigMock(),
                driverConfig: $driverConfig ?? $this->getDriverConfigMock(),
                widgetConfig: $widgetConfig ?? $this->getWidgetConfigMock(),
                rootWidgetConfig: $rootWidgetConfig ?? $this->getWidgetConfigMock(),
            );
    }

    protected function getAuxConfigMock(): IAuxConfig
    {
        return $this->createMock(IAuxConfig::class);
    }

    protected function getLoopConfigMock(): ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
    }

    protected function getOutputConfigMock(): IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    protected function getDriverConfigMock(): IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

    protected function getWidgetConfigMock(): IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    #[Test]
    public function canGetAuxConfig(): void
    {
        $auxConfig = $this->getAuxConfigMock();

        $config = $this->getTesteeInstance(
            auxConfig: $auxConfig,
        );

        self::assertSame($auxConfig, $config->getAuxConfig());
    }

    #[Test]
    public function canGetLoopConfig(): void
    {
        $loopConfig = $this->getLoopConfigMock();

        $config = $this->getTesteeInstance(
            loopConfig: $loopConfig,
        );

        self::assertSame($loopConfig, $config->getLoopConfig());
    }

    #[Test]
    public function canGetOutputConfig(): void
    {
        $outputConfig = $this->getOutputConfigMock();

        $config = $this->getTesteeInstance(
            outputConfig: $outputConfig,
        );

        self::assertSame($outputConfig, $config->getOutputConfig());
    }

    #[Test]
    public function canGetDriverConfig(): void
    {
        $driverConfig = $this->getDriverConfigMock();

        $config = $this->getTesteeInstance(
            driverConfig: $driverConfig,
        );

        self::assertSame($driverConfig, $config->getDriverConfig());
    }

    #[Test]
    public function canGetWidgetConfig(): void
    {
        $widgetConfig = $this->getWidgetConfigMock();

        $config = $this->getTesteeInstance(
            widgetConfig: $widgetConfig,
        );

        self::assertSame($widgetConfig, $config->getWidgetConfig());
        self::assertNotSame($widgetConfig, $config->getRootWidgetConfig());
    }

    #[Test]
    public function canGetRootWidgetConfig(): void
    {
        $rootWidgetConfig = $this->getWidgetConfigMock();

        $config = $this->getTesteeInstance(
            rootWidgetConfig: $rootWidgetConfig,
        );

        self::assertSame($rootWidgetConfig, $config->getRootWidgetConfig());
        self::assertNotSame($rootWidgetConfig, $config->getWidgetConfig());
    }
}
