<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Spinner\Contract\ISequencer;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\CharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Color\AnsiStyleConverter;
use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Spinner\Core\DriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\FrameRevolverBuilder;
use AlecRabbit\Spinner\Core\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Spinner\Core\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Sequencer;
use AlecRabbit\Spinner\Core\SpinnerBuilder;
use AlecRabbit\Spinner\Core\StyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\StyleFrameRenderer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\WidgetRevolverBuilder;
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
                spawnerCreatorCb: static function (ContainerInterface $container): IServiceSpawner {
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
                    throw new DomainException(
                        sprintf(
                            'Class [%s] is not available in this context.',
                            LoopProbeFactory::class
                        )
                    );
                },

                ILoopFactory::class => LoopFactory::class,
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
                ITimerFactory::class => TimerFactory::class,
                ICursorFactory::class => CursorFactory::class,
                IOutputFactory::class => OutputFactory::class,

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
