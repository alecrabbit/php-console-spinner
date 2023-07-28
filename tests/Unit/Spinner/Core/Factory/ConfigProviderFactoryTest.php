<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Factory\ConfigProviderFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConfigProviderFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
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
    ): IConfigProviderFactory {
        return
            new ConfigProviderFactory(
            );
    }
}
