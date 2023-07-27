<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ConfigProviderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConfigProvider::class, $driverBuilder);
    }

    public function getTesteeInstance(): IConfigProvider
    {
        return
            new ConfigProvider();
    }

//    #[Test]
    
}
