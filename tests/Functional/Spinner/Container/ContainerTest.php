<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Container;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ContainerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(Container::class, $container);
    }

    public function getTesteeInstance(): IContainer
    {
        return self::callMethod(Facade::class, 'getContainer');
    }
//
//    #[Test]
//    public function returnsConfigProvider(): void
//    {
//        $container = $this->getTesteeInstance();
//
//        $result = $container->get(IConfigProvider::class);
//
//        self::assertInstanceOf(ConfigProvider::class, $result);
//    }
}
