<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\WidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IConfigProvider $configProvider = null,
    ): IWidgetConfigFactory {
        return
            new WidgetConfigFactory(
                configProvider: $configProvider ?? $this->getConfigProviderMock(),
            );
    }

    private function getConfigProviderMock(): MockObject&IConfigProvider
    {
        return $this->createMock(IConfigProvider::class);
    }

    #[Test]
    public function canCreateWithoutWidgetSettings(): void
    {
        $config = $this->getConfigMock();
        $widgetConfig = $this->getWidgetConfigMock();

        $config
            ->expects(self::once())
            ->method('get')
            ->with(IWidgetConfig::class)
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

//        self::assertInstanceOf(WidgetConfig::class, $result);
        self::assertSame($widgetConfig, $result);
    }

    private function getConfigMock(): MockObject&IConfig
    {
        return $this->createMock(IConfig::class);
    }

    private function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    #[Test]
    public function canCreateWithWidgetSettings(): void
    {
        $widgetSettings = $this->getWidgetSettingsMock();

        $widgetSettings
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn(null)
        ;

        $config = $this->getConfigMock();
        $widgetConfig = $this->getWidgetConfigMock();

        $config
            ->expects(self::exactly(3))
            ->method('get')
            ->with(IWidgetConfig::class)
            ->willReturn($widgetConfig)
        ;

        $configProvider = $this->getConfigProviderMock();
        $configProvider
            ->expects(self::once())
            ->method('getConfig')
            ->willReturn($config)
        ;


        $factory = $this->getTesteeInstance($configProvider);

        $result = $factory->create($widgetSettings);

        self::assertInstanceOf(WidgetConfig::class, $result);
//        self::assertSame($widgetConfig, $result);
    }

    private function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }
}
