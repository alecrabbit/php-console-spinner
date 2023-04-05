<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequencer;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\CharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\CharFrameRenderer;
use AlecRabbit\Spinner\Core\Color\AnsiStyleConverter;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ICursorBuilder;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\IOutputBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerSetup;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\CursorBuilder;
use AlecRabbit\Spinner\Core\Defaults\AuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\DriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\LoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\SpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\WidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\DriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Core\FrameRevolverBuilder;
use AlecRabbit\Spinner\Core\IntegerNormalizer;
use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Core\OutputBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Sequencer;
use AlecRabbit\Spinner\Core\SpinnerBuilder;
use AlecRabbit\Spinner\Core\SpinnerSetup;
use AlecRabbit\Spinner\Core\StyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\StyleFrameRenderer;
use AlecRabbit\Spinner\Core\TimerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
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
                IDefaultsProvider::class => static function (ContainerInterface $container): IDefaultsProvider {
                    return
                        (new DefaultsProviderBuilder(
                            loopSettingsBuilder: $container->get(ILoopSettingsBuilder::class),
                            spinnerSettingsBuilder: $container->get(ISpinnerSettingsBuilder::class),
                            auxSettingsBuilder: $container->get(IAuxSettingsBuilder::class),
                            driverSettingsBuilder: $container->get(IDriverSettingsBuilder::class),
                            widgetSettingsBuilder: $container->get(IWidgetSettingsBuilder::class),
                            rootWidgetSettingsBuilder: $container->get(IWidgetSettingsBuilder::class),
                        ))
                            ->build()
                    ;
                },

                ILoopSettingsBuilder::class => static function (ContainerInterface $container): ILoopSettingsBuilder {
                    $loopProbe = null;
                    try {
                        $loopProbe = $container->get(ILoopProbeFactory::class)->getProbe();
                    } finally {
                        return new LoopSettingsBuilder($loopProbe);
                    }
                },

                ISpinnerSettingsBuilder::class =>
                    static function (ContainerInterface $container): ISpinnerSettingsBuilder {
                        $loopProbe = null;
                        try {
                            $loopProbe = $container->get(ILoopProbeFactory::class)->getProbe();
                        } finally {
                            return new SpinnerSettingsBuilder($loopProbe);
                        }
                    },

                IAuxSettingsBuilder::class => AuxSettingsBuilder::class,
                IDriverSettingsBuilder::class => DriverSettingsBuilder::class,
                IWidgetSettingsBuilder::class => WidgetSettingsBuilder::class,
                IAnsiStyleConverter::class => AnsiStyleConverter::class,
                ICharFrameCollectionRenderer::class => CharFrameCollectionRenderer::class,
                ICharFrameRenderer::class => CharFrameRenderer::class,
                IConfigBuilder::class => ConfigBuilder::class,
                ICursorBuilder::class => CursorBuilder::class,
                IDriverBuilder::class => DriverBuilder::class,
                IFrameFactory::class => FrameFactory::class,
                IFrameRevolverBuilder::class => FrameRevolverBuilder::class,
                IIntervalFactory::class => IntervalFactory::class,
                IIntervalNormalizer::class => IntervalNormalizer::class,
                ILoopFactory::class => LoopFactory::class,
                ILoopSetup::class => LoopSetup::class,
                IOutputBuilder::class => OutputBuilder::class,
                ISequencer::class => Sequencer::class,
                ISpinnerAttacherFactory::class => SpinnerAttacherFactory::class,
                ISpinnerBuilder::class => SpinnerBuilder::class,
                ISpinnerFactory::class => SpinnerFactory::class,
                ISpinnerSetup::class => SpinnerSetup::class,
                IStyleFrameCollectionRenderer::class => StyleFrameCollectionRenderer::class,
                IStyleFrameRenderer::class => StyleFrameRenderer::class,
                ITimerBuilder::class => TimerBuilder::class,
                IWidgetBuilder::class => WidgetBuilder::class,
                IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
                IWidthMeasurerFactory::class => WidthMeasurerFactory::class,

                IIntegerNormalizer::class => static function (ContainerInterface $container): IIntegerNormalizer {
                    /** @var IAuxSettings $auxSettings */
                    $auxSettings = $container->get(IDefaultsProvider::class)->getAuxSettings();
                    return
                        new IntegerNormalizer(
                            $auxSettings->getNormalizerMode()->getDivisor(),
                            IInterval::MIN_INTERVAL_MILLISECONDS
                        );
                },

                OptionStyleMode::class => static function (ContainerInterface $container): OptionStyleMode {
                    return $container->get(IDefaultsProvider::class)->getAuxSettings()->getOptionStyleMode();
                },


                ILoop::class => static function (ContainerInterface $container): ILoop {
                    return
                        $container->get(ILoopFactory::class)->getLoop();
                },

                ILoopProbeFactory::class => static function (): never {
                    throw new DomainException(
                        sprintf(
                            'Service for id [%s] is not available in this context.',
                            ILoopProbeFactory::class
                        )
                    );
                },

                ISpinnerAttacher::class => static function (ContainerInterface $container): ISpinnerAttacher {
                    return
                        $container->get(ISpinnerAttacherFactory::class)->getAttacher();
                },

                IWidthMeasurer::class => static function (ContainerInterface $container): IWidthMeasurer {
                    return
                        $container->get(IWidthMeasurerFactory::class)->create();
                },
            ],
        );
    }
}
