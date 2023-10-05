<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Container;

use AlecRabbit\Spinner\Asynchronous\Factory\LegacyLoopProbeFactory;
use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopProbeFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ContainerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(Container::class, $container);
    }

    public function getTesteeInstance(
        ?string $class = null,
        ?IDefinitionRegistry $registry = null,
    ): IContainer {
        $class ??= ContainerFactory::class;

        $registry ??= DefinitionRegistry::getInstance();

        $factory = new $class($registry);
        return self::callMethod($factory, 'createContainer');
    }
//
//    #[Test]
//    public function returnsNormalizerMethodMode(): void
//    {
//        $container = $this->getTesteeInstance();
//
//        $result = $container->get(NormalizerMethodMode::class);
//
//        self::assertInstanceOf(NormalizerMethodMode::class, $result);
//        self::assertSame(NormalizerMethodMode::BALANCED, $result);
//    }
//
//    #[Test]
//    public function returnsLoopProbeFactory(): void
//    {
//        $container = $this->getTesteeInstance();
//
//        $result = $container->get(ILoopProbeFactory::class);
//
//        self::assertInstanceOf(LoopProbeFactory::class, $result);
//    }

    #[Test]
    public function returnsConfigProvider(): void
    {
        $container = $this->getTesteeInstance();

        $result = $container->get(IConfigProvider::class);

        self::assertInstanceOf(ConfigProvider::class, $result);
    }
}
