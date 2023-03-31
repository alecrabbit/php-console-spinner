<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\DriverBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Contract\IContainerFactory;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use ArrayObject;
use Closure;
use Traversable;

final class ContainerFactory implements IContainerFactory
{
    protected static ?IContainer $container = null;

    public static function getContainer(): IContainer
    {
        return self::createContainer();
    }

    public static function createContainer(): IContainer
    {
        if (null === self::$container) {
            self::$container = new Container();
            self::initializeContainer(self::$container);
        }

        return self::$container;
    }

    protected static function initializeContainer(IContainer $container): void
    {
        foreach (self::getDefaultDefinitions($container) as $id => $service) {
            $container->add($id, $service);
        }
    }

    protected static function getDefaultDefinitions(IContainer $container): Traversable
    {
        $instanceProducer = static function (string $class) use ($container): Closure {
            return
                static function () use ($class, $container): object {
                    return new $class($container);
                };
        };

        return new ArrayObject(
            [
                IConfigBuilder::class => $instanceProducer(ConfigBuilder::class),
                IDefaultsProvider::class => DefaultsProvider::class,
                IDriverBuilder::class => $instanceProducer(DriverBuilder::class),
                IWidgetBuilder::class => $instanceProducer(WidgetBuilder::class),
                IWidgetRevolverBuilder::class => $instanceProducer(WidgetRevolverBuilder::class),
                ILoopProbeFactory::class => $instanceProducer(LoopProbeFactory::class),
                IRevolverFactory::class => $instanceProducer(RevolverFactory::class),
                IFrameRevolverBuilder::class => $instanceProducer(FrameRevolverBuilder::class),
                ISpinnerFactory::class => $instanceProducer(SpinnerFactory::class),
                ISpinnerBuilder::class => $instanceProducer(SpinnerBuilder::class),
                IFrameFactory::class => $instanceProducer(FrameFactory::class),
            ],
        );
    }
}
