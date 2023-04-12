<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Contract\Output\ISequencer;
use AlecRabbit\Spinner\Core\BufferedOutputBuilder;
use AlecRabbit\Spinner\Core\CharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\CharFrameRenderer;
use AlecRabbit\Spinner\Core\Color\AnsiStyleConverter;
use AlecRabbit\Spinner\Core\ConfigBuilder;
use AlecRabbit\Spinner\Core\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverAttacher;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerAttacher;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerSetup;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\Defaults\AuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILegacySpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\DriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\LegacySpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\LoopSettingsFactory;
use AlecRabbit\Spinner\Core\Defaults\WidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\DriverBuilder;
use AlecRabbit\Spinner\Core\DriverOutputBuilder;
use AlecRabbit\Spinner\Core\DriverSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IContainerSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverAttacherSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacySpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacySpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Core\LegacyFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\IntegerNormalizer;
use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Spinner\Core\LegacyDriverBuilder;
use AlecRabbit\Spinner\Core\LegacySpinnerBuilder;
use AlecRabbit\Spinner\Core\LegacySpinnerSetup;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Core\LoopSetupBuilder;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\ILegacyFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Sequencer;
use AlecRabbit\Spinner\Core\StyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\StyleFrameRenderer;
use AlecRabbit\Spinner\Core\TimerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\DomainException;
use Psr\Container\ContainerInterface;
use Traversable;

final class ContainerSingletonFactory implements IContainerSingletonFactory
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
        // TODO (2023-04-10 20:21) [Alec Rabbit]: consider extracting definitions?
        yield from [
            IDefaultsProvider::class => static function (ContainerInterface $container): IDefaultsProvider {
                return $container->get(IDefaultsProviderBuilder::class)->build();
            },

            IDefaultsProviderBuilder::class => DefaultsProviderBuilder::class,

            ILoopSettingsFactory::class => static function (ContainerInterface $container): ILoopSettingsFactory {
                $loopProbe = null;
                $pcntlExtensionProbe = null;
                try {
                    $loopProbe = $container->get(ILoopProbeFactory::class)->getProbe();
                    $pcntlExtensionProbe = $container->get(ISignalProcessingProbe::class)->getProbe();
                } finally {
                    return new LoopSettingsFactory($loopProbe, $pcntlExtensionProbe);
                }
            },

            IDriver::class => static function (ContainerInterface $container): IDriver {
                return $container->get(IDriverSingletonFactory::class)->getDriver();
            },

            IDriverSingletonFactory::class => DriverSingletonFactory::class,
            IDriverBuilder::class => DriverBuilder::class,
            IDriverOutputFactory::class => DriverOutputFactory::class,
            IDriverOutputBuilder::class => DriverOutputBuilder::class,
            IDriverSettings::class => static function (ContainerInterface $container): IDriverSettings {
                return $container->get(IDefaultsProvider::class)->getDriverSettings();
            },
            IBufferedOutputSingletonFactory::class => BufferedOutputSingletonFactory::class,
            IResourceStream::class => static function (ContainerInterface $container): IResourceStream {
                // TODO (2023-04-11 12:15) [Alec Rabbit]: get stream from DefaultsProvider
                //  return $container->get(IDefaultsProvider::class)-> ~;
                return new ResourceStream(STDERR);
            },
            IConsoleCursorFactory::class => ConsoleCursorFactory::class,
            ITimerFactory::class => TimerFactory::class,
            IAnsiStyleConverter::class => AnsiStyleConverter::class,
            IAuxSettingsBuilder::class => AuxSettingsBuilder::class,
            IBufferedOutputBuilder::class => BufferedOutputBuilder::class,
            ILoopSetupFactory::class => LoopSetupFactory::class,
            ICharFrameCollectionRenderer::class => CharFrameCollectionRenderer::class,
            ICharFrameRenderer::class => CharFrameRenderer::class,
            IConsoleCursorBuilder::class => ConsoleCursorBuilder::class,
            IDriverAttacherSingletonFactory::class => DriverAttacherSingletonFactory::class,
            IDriverSettingsBuilder::class => DriverSettingsBuilder::class,
            IDriverSetup::class => DriverSetup::class,
            IFrameFactory::class => FrameFactory::class,
            ILegacyFrameRevolverBuilder::class => LegacyFrameRevolverBuilder::class,
            IIntervalFactory::class => IntervalFactory::class,
            ISpinnerFactory::class => SpinnerFactory::class,
            IWidgetFactory::class => WidgetFactory::class,
            IWidgetRevolverFactory::class => WidgetRevolverFactory::class,
            IStyleRevolverFactory::class => StyleRevolverFactory::class,
            ICharRevolverFactory::class => CharRevolverFactory::class,
            IFrameRevolverBuilder::class => FrameRevolverBuilder::class,
            IIntervalNormalizer::class => IntervalNormalizer::class,
            ILoopSingletonFactory::class => LoopSingletonFactory::class,
            ILoopSetup::class => LoopSetup::class,
            ILoopSetupBuilder::class => LoopSetupBuilder::class,
            ISequencer::class => Sequencer::class,
            IStyleFrameCollectionRenderer::class => StyleFrameCollectionRenderer::class,
            IStyleFrameRenderer::class => StyleFrameRenderer::class,
            ITimerBuilder::class => TimerBuilder::class,
            IWidgetBuilder::class => WidgetBuilder::class,
            IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
            IWidgetSettingsBuilder::class => WidgetSettingsBuilder::class,
            IWidthMeasurerFactory::class => WidthMeasurerFactory::class,

            IIntegerNormalizer::class => static function (ContainerInterface $container): IIntegerNormalizer {
                /** @var IAuxSettings $auxSettings */
                $auxSettings = $container->get(IDefaultsProvider::class)->getAuxSettings();
                return
                    new IntegerNormalizer(
                        $auxSettings->getOptionNormalizerMode()->getDivisor(),
                        IInterval::MIN_INTERVAL_MILLISECONDS
                    );
            },

            OptionStyleMode::class => static function (ContainerInterface $container): OptionStyleMode {
                return $container->get(IDefaultsProvider::class)->getAuxSettings()->getOptionStyleMode();
            },

            OptionNormalizerMode::class => static function (ContainerInterface $container): OptionNormalizerMode {
                // TODO (2023-04-11 11:41) [Alec Rabbit]: get from DefaultsProvider
                //  $container->get(IDefaultsProvider::class)-> ~ ->getNormalizerMode();
                return OptionNormalizerMode::BALANCED;
            },


            ILoop::class => static function (ContainerInterface $container): ILoop {
                return
                    $container->get(ILoopSingletonFactory::class)->getLoop();
            },

            ILoopProbeFactory::class => static function (): never {
                throw new DomainException(
                    sprintf(
                        'Service for id [%s] is not available in this context.',
                        ILoopProbeFactory::class
                    )
                );
            },

            IDriverAttacher::class => static function (ContainerInterface $container): IDriverAttacher {
                return
                    $container->get(IDriverAttacherSingletonFactory::class)->getAttacher();
            },

            IWidthMeasurer::class => static function (ContainerInterface $container): IWidthMeasurer {
                return
                    $container->get(IWidthMeasurerFactory::class)->create();
            },


            ILegacyDriverBuilder::class => LegacyDriverBuilder::class,
            ILegacySpinnerAttacher::class =>
                static function (ContainerInterface $container): ILegacySpinnerAttacher {
                    return
                        $container->get(ILegacySpinnerAttacherFactory::class)->getAttacher();
                },
            ILegacySpinnerAttacherFactory::class => LegacySpinnerAttacherFactory::class,
            ILegacySpinnerBuilder::class => LegacySpinnerBuilder::class,
            ILegacySpinnerFactory::class => LegacySpinnerFactory::class,
            ILegacySpinnerSetup::class => LegacySpinnerSetup::class,

            ILegacySpinnerSettingsBuilder::class =>
                static function (ContainerInterface $container): ILegacySpinnerSettingsBuilder {
                    $loopProbe = null;
                    try {
                        $loopProbe = $container->get(ILoopProbeFactory::class)->getProbe();
                    } finally {
                        return new LegacySpinnerSettingsBuilder($loopProbe);
                    }
                },
        ];
    }
}
