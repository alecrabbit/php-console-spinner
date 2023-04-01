<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Instantiator;
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
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Exception\DomainException;
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
        Instantiator::registerContainer($container);

        foreach (self::getDefaultDefinitions($container) as $id => $service) {
            $container->add($id, $service);
        }
    }

    protected static function getDefaultDefinitions(IContainer $container): Traversable
    {
        return new ArrayObject(
            [
                IContainer::class => static fn(): IContainer => $container,

                IConfigBuilder::class => self::getInstantiatorCallback(ConfigBuilder::class),
                IDefaultsProvider::class => DefaultsProvider::class,
                IDriverBuilder::class => self::getInstantiatorCallback(DriverBuilder::class),
                IWidgetBuilder::class => self::getInstantiatorCallback(WidgetBuilder::class),
                IWidgetRevolverBuilder::class => self::getInstantiatorCallback(WidgetRevolverBuilder::class),
                ILoopProbeFactory::class => static function (): never {
                    throw new DomainException('LoopProbeFactory is not available in this context.');
                },
                IRevolverFactory::class => self::getInstantiatorCallback(RevolverFactory::class),
                IFrameRevolverBuilder::class => self::getInstantiatorCallback(FrameRevolverBuilder::class),
                ISpinnerFactory::class => self::getInstantiatorCallback(SpinnerFactory::class),
                ISpinnerBuilder::class => self::getInstantiatorCallback(SpinnerBuilder::class),
                IFrameFactory::class => FrameFactory::class,
            ],
        );
    }

    protected static function getInstantiatorCallback(string $class): Closure
    {
        return static function () use ($class): object {
            return Instantiator::createInstance($class);
        };
    }
}
