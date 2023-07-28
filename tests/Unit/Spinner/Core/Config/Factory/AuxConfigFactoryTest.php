<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\AuxConfigFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AuxConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(AuxConfigFactory::class, $factory);
    }

    public function getTesteeInstance(): IAuxConfigFactory
    {
        return
            new AuxConfigFactory();
    }
//
//    #[Test]
//    public function canCreate(): void
//    {
//        $config = $this->getConfigMock();
//
//        $configFactory = $this->getConfigFactoryMock();
//        $configFactory
//            ->expects($this->once())
//            ->method('create')
//            ->willReturn($config);
//
//        $factory = $this->getTesteeInstance(
//            configFactory: $configFactory,
//        );
//
//        $configProvider = $factory->create();
//
//        self::assertInstanceOf(ConfigProvider::class, $configProvider);
//        self::assertSame($config, $configProvider->getConfig());
//    }
//
//    protected function getConfigFactoryMock(): MockObject&IConfigFactory
//    {
//        return $this->createMock(IConfigFactory::class);
//    }
//
//    protected function getConfigMock(): MockObject&IConfig
//    {
//        return $this->createMock(IConfig::class);
//    }
}
