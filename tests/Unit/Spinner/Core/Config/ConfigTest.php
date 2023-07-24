<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(Config::class, $config);
    }

    protected function getTesteeInstance(
        ?IAuxConfig $auxConfig = null,
    ): IConfig {
        return
            new Config(
                auxConfig: $auxConfig ?? $this->getAuxConfigMock(),
            );
    }

    #[Test]
    public function canGetAuxConfig(): void
    {
        $auxConfig = $this->getAuxConfigMock();

        $config = $this->getTesteeInstance(
            auxConfig: $auxConfig,
        );

        self::assertSame($auxConfig, $config->getAuxConfig());
    }
}
