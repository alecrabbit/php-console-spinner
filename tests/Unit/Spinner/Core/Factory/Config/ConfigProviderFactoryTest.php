<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Factory\Config\ConfigProviderFactory;
use AlecRabbit\Spinner\Core\Factory\Config\Contract\IConfigProviderFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConfigProviderFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigProviderFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IConfigFactory $configFactory = null,
    ): IConfigProviderFactory
    {
        return
            new ConfigProviderFactory(
                configFactory: $configFactory ?? $this->getConfigFactoryMock(),
            );
    }

    #[Test]
    public function canCreate(): void
    {
        $config = $this->getConfigMock();

        $configFactory = $this->getConfigFactoryMock();
        $configFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($config);

        $factory = $this->getTesteeInstance(
            configFactory: $configFactory,
        );

        $configProvider = $factory->create();

        self::assertInstanceOf(ConfigProvider::class, $configProvider);
        self::assertSame($config, $configProvider->getConfig());
    }

    protected function getConfigFactoryMock(): MockObject&IConfigFactory
    {
        return $this->createMock(IConfigFactory::class);
    }

    protected function getConfigMock(): MockObject&IConfig
    {
        return $this->createMock(IConfig::class);
    }
}
