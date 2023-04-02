<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Spinner\Contract\ISequencer;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\AnsiStyleConverter;
use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\DriverBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Contract\IContainerFactory;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Exception\DomainException;
use ArrayObject;
use Psr\Container\ContainerInterface;
use Traversable;

final class ContainerFactory implements IContainerFactory
{
    protected static ?IContainer $container = null;

    public static function getContainer(): IContainer
    {
        return self::createContainer();
    }

    protected static function createContainer(): IContainer
    {
        if (null === self::$container) {
            self::$container = new Container(
                spawnerCb: static function (ContainerInterface $container): IServiceSpawner {
                    return new ServiceSpawner($container);
                },
            );
            self::initializeContainer(self::$container);
        }

        return self::$container;
    }

    protected static function initializeContainer(IContainer $container): void
    {
        foreach (self::getDefaultDefinitions() as $id => $service) {
            $container->add($id, $service);
        }
    }

    protected static function getDefaultDefinitions(): Traversable
    {
        // FIXME: extract definitions declarations? container factory depends on all other services
        return new ArrayObject(
            [
                IDefaultsProvider::class => new DefaultsProvider(),

                ILoopProbeFactory::class => static function (): never {
                    throw new DomainException('LoopProbeFactory is not available in this context.');
                },
                IFrameFactory::class => FrameFactory::class,
                IConfigBuilder::class => ConfigBuilder::class,
                IDriverBuilder::class => DriverBuilder::class,
                IWidgetBuilder::class => WidgetBuilder::class,
                IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
                IRevolverFactory::class => RevolverFactory::class,
                IFrameRevolverBuilder::class => FrameRevolverBuilder::class,
                ISpinnerFactory::class => SpinnerFactory::class,
                ISpinnerBuilder::class => SpinnerBuilder::class,
                IIntervalFactory::class => IntervalFactory::class,
                IIntervalNormalizer::class => IntervalNormalizer::class,
                IStyleFrameRenderer::class => StyleFrameRenderer::class,
                IAnsiStyleConverter::class => AnsiStyleConverter::class,
                IStyleFrameCollectionRenderer::class => StyleFrameCollectionRenderer::class,
                ICharFrameCollectionRenderer::class => CharFrameCollectionRenderer::class,
                ISequencer::class => Sequencer::class,

                NormalizerMode::class => static function (ContainerInterface $container): NormalizerMode {
                    return NormalizerMode::BALANCED;
                    // TODO
                    //  return $container->get(IDefaultsProvider::class)->getAuxSettings()->getNormalizerMode();
                },
                OptionStyleMode::class => static function (ContainerInterface $container): OptionStyleMode {
                    return OptionStyleMode::ANSI8;
                    // TODO
                    //  return $container->get(IDefaultsProvider::class)->getAuxSettings()->getOptionStyleMode();
                },
            ],
        );
    }
}
