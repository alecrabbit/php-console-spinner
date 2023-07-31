<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigProviderFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Factory\ConfigProviderFactory;
use AlecRabbit\Spinner\Core\ConfigProvider;
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
    ): IConfigProviderFactory {
        return
            new ConfigProviderFactory(
                configFactory: $configFactory ?? $this->getConfigFactoryMock(),
            );
    }

    protected function getConfigFactoryMock(): MockObject&IConfigFactory
    {
        return $this->createMock(IConfigFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $config = $this->getConfigMock();

        $configFactory = $this->getConfigFactoryMock();
        $configFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($config)
        ;

        $factory = $this->getTesteeInstance(
            configFactory: $configFactory,
        );

        $configProvider = $factory->create();

        self::assertInstanceOf(ConfigProvider::class, $configProvider);
        self::assertSame($config, $configProvider->getConfig());
    }

    protected function getConfigMock(): MockObject&IConfig
    {
        return $this->createMock(IConfig::class);
    }
}
