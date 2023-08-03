<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\ConfigFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IAuxConfigFactory $auxConfigFactory = null,
        ?ILoopConfigFactory $loopConfigFactory = null,
        ?IOutputConfigFactory $outputConfigFactory = null,
        ?IDriverConfigFactory $driverConfigFactory = null,
        ?IWidgetConfigFactory $widgetConfigFactory = null,
        ?IWidgetConfigFactory $rootWidgetConfigFactory = null,
    ): IConfigFactory {
        return
            new ConfigFactory(
                auxConfigFactory: $auxConfigFactory ?? $this->getAuxConfigFactoryMock(),
                loopConfigFactory: $loopConfigFactory ?? $this->getLoopConfigFactoryMock(),
                outputConfigFactory: $outputConfigFactory ?? $this->getOutputConfigFactoryMock(),
                driverConfigFactory: $driverConfigFactory ?? $this->getDriverConfigFactoryMock(),
                widgetConfigFactory: $widgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
                rootWidgetConfigFactory: $rootWidgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
            );
    }

    protected function getAuxConfigFactoryMock(): MockObject&IAuxConfigFactory
    {
        return $this->createMock(IAuxConfigFactory::class);
    }

    protected function getLoopConfigFactoryMock(): MockObject&ILoopConfigFactory
    {
        return $this->createMock(ILoopConfigFactory::class);
    }

    protected function getOutputConfigFactoryMock(): MockObject&IOutputConfigFactory
    {
        return $this->createMock(IOutputConfigFactory::class);
    }

    protected function getDriverConfigFactoryMock(): MockObject&IDriverConfigFactory
    {
        return $this->createMock(IDriverConfigFactory::class);
    }

    protected function getWidgetConfigFactoryMock(): MockObject&IWidgetConfigFactory
    {
        return $this->createMock(IWidgetConfigFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $auxConfig = $this->getAuxConfigMock();
        $loopConfig = $this->getLoopConfigMock();
        $outputConfig = $this->getOutputConfigMock();
        $driverConfig = $this->getDriverConfigMock();
        $widgetConfig = $this->getWidgetConfigMock();
        $rootWidgetConfig = $this->getWidgetConfigMock();

        $auxConfigFactory = $this->getAuxConfigFactoryMock();
        $loopConfigFactory = $this->getLoopConfigFactoryMock();
        $outputConfigFactory = $this->getOutputConfigFactoryMock();
        $driverConfigFactory = $this->getDriverConfigFactoryMock();
        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $rootWidgetConfigFactory = $this->getWidgetConfigFactoryMock();

        $auxConfigFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($auxConfig)
        ;
        $loopConfigFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($loopConfig)
        ;
        $outputConfigFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($outputConfig)
        ;
        $driverConfigFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($driverConfig)
        ;
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($widgetConfig)
        ;
        $rootWidgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($rootWidgetConfig)
        ;

        $factory = $this->getTesteeInstance(
            auxConfigFactory: $auxConfigFactory,
            loopConfigFactory: $loopConfigFactory,
            outputConfigFactory: $outputConfigFactory,
            driverConfigFactory: $driverConfigFactory,
            widgetConfigFactory: $widgetConfigFactory,
            rootWidgetConfigFactory: $rootWidgetConfigFactory,
        );

        self::assertInstanceOf(ConfigFactory::class, $factory);

        $config = $factory->create();

        self::assertInstanceOf(Config::class, $config);
        self::assertSame($auxConfig, $config->getAuxConfig());
        self::assertSame($loopConfig, $config->getLoopConfig());
        self::assertSame($outputConfig, $config->getOutputConfig());
        self::assertSame($driverConfig, $config->getDriverConfig());
        self::assertSame($widgetConfig, $config->getWidgetConfig());
        self::assertSame($rootWidgetConfig, $config->getRootWidgetConfig());
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
