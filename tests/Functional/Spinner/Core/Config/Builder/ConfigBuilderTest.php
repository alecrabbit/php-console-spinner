<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $auxConfig = $this->getAuxConfigMock();
        $loopConfig = $this->getLoopConfigMock();
        $outputConfig = $this->getOutputConfigMock();
        $driverConfig = $this->getDriverConfigMock();
        $widgetConfig = $this->getWidgetConfigMock();
        $rootWidgetConfig = $this->getWidgetConfigMock();

        $config = $configBuilder
            ->withAuxConfig($auxConfig)
            ->withLoopConfig($loopConfig)
            ->withOutputConfig($outputConfig)
            ->withDriverConfig($driverConfig)
            ->withWidgetConfig($widgetConfig)
            ->withRootWidgetConfig($rootWidgetConfig)
            ->build()
        ;

        self::assertInstanceOf(Config::class, $config);

    }

    protected function getTesteeInstance(): IConfigBuilder
    {
        return
            new ConfigBuilder();
    }

    protected function getAuxConfigMock(): MockObject&IAuxConfig
    {
        return $this->createMock(IAuxConfig::class);
    }

    protected function getLoopConfigMock(): MockObject&ILoopConfig
    {
        return $this->createMock(ILoopConfig::class);
    }

    protected function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    protected function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

    protected function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }
}
