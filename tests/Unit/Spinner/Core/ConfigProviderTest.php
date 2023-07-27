<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConfigProviderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigProvider::class, $driverBuilder);
    }

    public function getTesteeInstance(
        ?IConfig $config = null,
    ): IConfigProvider {
        return
            new ConfigProvider(
                config: $config ?? $this->getConfigMock(),
            );
    }

    protected function getConfigMock(): MockObject&IConfig
    {
        return $this->createMock(IConfig::class);
    }
    #[Test]
    public function canGetConfig(): void
    {
        $config = $this->getConfigMock();

        $configProvider = $this->getTesteeInstance(
            config: $config,
        );

        self::assertSame($config, $configProvider->getConfig());
    }

}
