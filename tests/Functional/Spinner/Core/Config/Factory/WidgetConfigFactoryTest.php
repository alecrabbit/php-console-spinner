<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\WidgetConfigFactory;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getConfigMock();
        $config
            ->expects(self::once())
            ->method('get')
            ->with(IWidgetConfig::class)
            ->willReturn($this->getWidgetConfigMock())
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

        self::assertInstanceOf(WidgetConfigFactory::class, $factory);
    }

    private function getConfigMock(): MockObject&IConfig
    {
        return $this->createMock(IConfig::class);
    }

    private function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    private function getConfigProviderMock(): MockObject&IConfigProvider
    {
        return $this->createMock(IConfigProvider::class);
    }

    public function getTesteeInstance(
        ?IConfigProvider $configProvider = null,
    ): IWidgetConfigFactory {
        return
            new WidgetConfigFactory(
                configProvider: $configProvider ?? $this->getConfigProviderMock(),
            );
    }
}
