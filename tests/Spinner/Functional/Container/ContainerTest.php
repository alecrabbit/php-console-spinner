<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Container;

use AlecRabbit\Spinner\Container\Builder\ContainerBuilder;
use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Driver\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Output\BufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\Output;
use AlecRabbit\Spinner\Core\Output\StringBuffer;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
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
        $containerBuilder = new ContainerBuilder();

        return $containerBuilder
            ->withRegistry(DefinitionRegistry::getInstance())
            ->withFactory(new ContainerFactory())
            ->build()
        ;
    }

    #[Test]
    public function canGetServiceAndItIsSameInstanceOfServiceEveryTime(): void
    {
        $container = $this->getTesteeInstance();

        $serviceOne = $container->get(IBuffer::class);
        self::assertInstanceOf(StringBuffer::class, $serviceOne);
        self::assertSame($serviceOne, $container->get(IBuffer::class));

        $serviceTwo = $container->get(IBufferedOutput::class);
        self::assertInstanceOf(BufferedOutput::class, $serviceTwo);
        self::assertSame($serviceTwo, $container->get(IBufferedOutput::class));

        $serviceThree = $container->get(ISettingsProvider::class);
        self::assertSame($serviceThree, $container->get(ISettingsProvider::class));
    }

    #[Test]
    public function canGetServiceAndItIsDifferentInstanceOfServiceEveryTime(): void
    {
        $container = $this->getTesteeInstance();

        $serviceOne = $container->get(IOutput::class);
        self::assertInstanceOf(Output::class, $serviceOne);
        self::assertNotSame($serviceOne, $container->get(IOutput::class));

        $serviceTwo = $container->get(IWidgetConfig::class);
        self::assertInstanceOf(WidgetConfig::class, $serviceTwo);
        self::assertNotSame($serviceTwo, $container->get(IWidgetConfig::class));

        $serviceThree = $container->get(IDriverBuilder::class);
        self::assertInstanceOf(DriverBuilder::class, $serviceThree);
        self::assertNotSame($serviceThree, $container->get(IDriverBuilder::class));
    }
}
