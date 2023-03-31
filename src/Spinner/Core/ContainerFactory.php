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
use AlecRabbit\Spinner\Core\Config\WidgetBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use ArrayObject;
use Traversable;

final class ContainerFactory
{
    protected static ?IContainer $container = null;

    public static function getContainer(): IContainer
    {
        return self::createContainer();
    }

    public static function createContainer(): IContainer
    {
        if (null === self::$container) {
            self::$container = self::initializeContainer();
        }

        return self::$container;
    }

    protected static function initializeContainer(): IContainer
    {
        $container = new Container();
        foreach (self::getDefaultDefinitions($container) as $id => $service) {
            $container->add($id, $service);
        }
        return $container;
    }

    protected static function getDefaultDefinitions(IContainer $container): Traversable
    {
        return new ArrayObject(
            [
                IConfigBuilder::class =>
                    static function () use ($container): IConfigBuilder {
                        return new ConfigBuilder($container);
                    },
                IDefaultsProvider::class => DefaultsProvider::class,
                IDriverBuilder::class =>
                    static function () use ($container): IDriverBuilder {
                        return new DriverBuilder($container);
                    },
                IWidgetBuilder::class =>
                    static function () use ($container): IWidgetBuilder {
                        return new WidgetBuilder($container);
                    },
                IWidgetRevolverBuilder::class =>
                    static function () use ($container): IWidgetRevolverBuilder {
                        return new WidgetRevolverBuilder($container);
                    },
                ILoopProbeFactory::class =>
                    static function () use ($container): ILoopProbeFactory {
                        return
                            new LoopProbeFactory($container, new ArrayObject([]),);
                    },
                IRevolverFactory::class =>
                    static function () use ($container): IRevolverFactory {
                        return
                            new RevolverFactory($container);
                    },
                IFrameRevolverBuilder::class =>
                    static function () use ($container): IFrameRevolverBuilder {
                        return
                            new FrameRevolverBuilder($container);
                    },
            ],
        );
    }
}
