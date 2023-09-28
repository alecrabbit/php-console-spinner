<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\RootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RootWidgetConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getConfigMock();
        $config
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IRootWidgetConfig::class))
            ->willReturn($this->getRootWidgetConfigMock())
        ;
        $configProvider = $this->getConfigProviderMock();
        $configProvider
            ->expects(self::once())
            ->method('getConfig')
            ->willReturn($config)
        ;
        $factory = $this->getTesteeInstance(
            configProvider: $configProvider,
        );


        self::assertInstanceOf(RootWidgetConfigFactory::class, $factory);
    }

    private function getConfigMock(): MockObject&IConfig
    {
        return $this->createMock(IConfig::class);
    }

    private function getRootWidgetConfigMock(): MockObject&IRootWidgetConfig
    {
        return $this->createMock(IRootWidgetConfig::class);
    }

    private function getConfigProviderMock(): MockObject&IConfigProvider
    {
        return $this->createMock(IConfigProvider::class);
    }

    public function getTesteeInstance(
        ?IConfigProvider $configProvider = null,
    ): IRootWidgetConfigFactory {
        return
            new RootWidgetConfigFactory(
                configProvider: $configProvider ?? $this->getConfigProviderMock(),
            );
    }

    private function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    #[Test]
    public function canCreateWithoutWidgetSettings(): void
    {
        $config = $this->getConfigMock();
        $widgetConfig = $this->getRootWidgetConfigMock();

        $config
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IRootWidgetConfig::class))
            ->willReturn($widgetConfig)
        ;

        $configProvider = $this->getConfigProviderMock();
        $configProvider
            ->expects(self::once())
            ->method('getConfig')
            ->willReturn($config)
        ;


        $factory = $this->getTesteeInstance($configProvider);

        $result = $factory->create();

        self::assertSame($widgetConfig, $result);
    }

}
