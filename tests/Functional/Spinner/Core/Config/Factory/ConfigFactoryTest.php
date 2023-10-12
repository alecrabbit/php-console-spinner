<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRuntimeRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
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
        ?IRuntimeRootWidgetConfigFactory $rootWidgetConfigFactory = null,
    ): IConfigFactory {
        return
            new ConfigFactory(
                auxConfigFactory: $auxConfigFactory ?? $this->getAuxConfigFactoryMock(),
                loopConfigFactory: $loopConfigFactory ?? $this->getLoopConfigFactoryMock(),
                outputConfigFactory: $outputConfigFactory ?? $this->getOutputConfigFactoryMock(),
                driverConfigFactory: $driverConfigFactory ?? $this->getDriverConfigFactoryMock(),
                widgetConfigFactory: $widgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
                rootWidgetConfigFactory: $rootWidgetConfigFactory ?? $this->getRootWidgetConfigFactoryMock(),
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

    protected function getRootWidgetConfigFactoryMock(): MockObject&IRuntimeRootWidgetConfigFactory
    {
        return $this->createMock(IRuntimeRootWidgetConfigFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $auxConfig = $this->getAuxConfigMock();
        $auxConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IAuxConfig::class)
        ;

        $loopConfig = $this->getLoopConfigMock();
        $loopConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(ILoopConfig::class)
        ;

        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IOutputConfig::class)
        ;

        $driverConfig = $this->getDriverConfigMock();
        $driverConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IDriverConfig::class)
        ;

        $widgetConfig = $this->getWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IWidgetConfig::class)
        ;

        $rootWidgetConfig = $this->getRootWidgetConfigMock();
        $rootWidgetConfig
            ->expects(self::once())
            ->method('getIdentifier')
            ->willReturn(IRootWidgetConfig::class)
        ;

        $auxConfigFactory = $this->getAuxConfigFactoryMock();
        $loopConfigFactory = $this->getLoopConfigFactoryMock();
        $outputConfigFactory = $this->getOutputConfigFactoryMock();
        $driverConfigFactory = $this->getDriverConfigFactoryMock();
        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $rootWidgetConfigFactory = $this->getRootWidgetConfigFactoryMock();

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

        $auxConfigFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($auxConfig)
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
        self::assertInstanceOf(Config::class, $factory->create());
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

    protected function getRootWidgetConfigMock(): MockObject&IRootWidgetConfig
    {
        return $this->createMock(IRootWidgetConfig::class);
    }

}
