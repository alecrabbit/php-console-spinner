<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
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
        ?IRootWidgetConfigFactory $rootWidgetConfigFactory = null,
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
    protected function getRootWidgetConfigFactoryMock(): MockObject&IRootWidgetConfigFactory
    {
        return $this->createMock(IRootWidgetConfigFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $auxConfigFactory = $this->getAuxConfigFactoryMock();
        $loopConfigFactory = $this->getLoopConfigFactoryMock();
        $outputConfigFactory = $this->getOutputConfigFactoryMock();
        $driverConfigFactory = $this->getDriverConfigFactoryMock();
        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $rootWidgetConfigFactory = $this->getRootWidgetConfigFactoryMock();

        $auxConfigFactory
            ->expects(self::once())
            ->method('create')
        ;
        $loopConfigFactory
            ->expects(self::once())
            ->method('create')
        ;
        $outputConfigFactory
            ->expects(self::once())
            ->method('create')
        ;
        $driverConfigFactory
            ->expects(self::once())
            ->method('create')
        ;
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
        ;
        $rootWidgetConfigFactory
            ->expects(self::once())
            ->method('create')
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
}
