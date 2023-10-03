<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Builder\BufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ILoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ISignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\IntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\LoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacySettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\LegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\LegacyDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\LegacySettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\LegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\SignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Builder\TimerBuilder;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigProviderFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Config\Factory\ConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\ConfigProviderFactory;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Core\Config\OutputConfig;
use AlecRabbit\Spinner\Core\Config\RootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\DriverSetup;
use AlecRabbit\Spinner\Core\Factory\BufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlersSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\FrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\Legacy\ILegacyWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Legacy\LegacyWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\LoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Factory\LoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\SignalHandlersSetupFactory;
use AlecRabbit\Spinner\Core\Factory\SignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\TerminalProbeFactory;
use AlecRabbit\Spinner\Core\Factory\TerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\TimerFactory;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\PaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\PatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Settings\Builder\SettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IColorSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopAvailabilityDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Detector\LoopAvailabilityDetector;
use AlecRabbit\Spinner\Core\Settings\Factory\DefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\DetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\SettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\UserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\SignalHandlersSetup;
use AlecRabbit\Spinner\Core\Terminal\NativeTerminalProbe;
use AlecRabbit\Spinner\Core\Widget\Builder\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Builder\WidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Builder\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetCompositeFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\WidgetRevolverFactory;
use AlecRabbit\Spinner\Probes;
use Psr\Container\ContainerInterface;

// @codeCoverageIgnoreStart

$definitions = DefinitionRegistry::getInstance();

foreach (definitions() as $id => $definition) {
    $definitions->bind($id, $definition);
}

function definitions(): Traversable
{
    yield from [
        ILegacyAuxSettingsBuilder::class => LegacyAuxSettingsBuilder::class,
        IBufferedOutputBuilder::class => BufferedOutputBuilder::class,
        IBufferedOutputSingletonFactory::class => BufferedOutputSingletonFactory::class,
        ICharFrameRevolverFactory::class => CharFrameRevolverFactory::class,
        IConsoleCursorBuilder::class => ConsoleCursorBuilder::class,
        IConsoleCursorFactory::class => ConsoleCursorFactory::class,

        IConfigFactory::class => ConfigFactory::class,
        IConfigProviderFactory::class => ConfigProviderFactory::class,
        IConfigProvider::class => static function (ContainerInterface $container): IConfigProvider {
            return $container->get(IConfigProviderFactory::class)->create();
        },

        IDriverBuilder::class => DriverBuilder::class,
        IDriverFactory::class => DriverFactory::class,
        IDriverLinkerFactory::class => DriverLinkerFactory::class,
        IDriverOutputBuilder::class => DriverOutputBuilder::class,
        IDriverOutputFactory::class => DriverOutputFactory::class,
        ILegacyDriverSettingsBuilder::class => LegacyDriverSettingsBuilder::class,
        IDriverSetup::class => DriverSetup::class,
        IFrameCollectionFactory::class => FrameCollectionFactory::class,
        IFrameRevolverBuilder::class => FrameRevolverBuilder::class,
        IIntegerNormalizerBuilder::class => IntegerNormalizerBuilder::class,
        IIntervalFactory::class => IntervalFactory::class,
        IIntervalNormalizerFactory::class => IntervalNormalizerFactory::class,
        ILoopAutoStarterBuilder::class => LoopAutoStarterBuilder::class,
        ILoopAutoStarterFactory::class => LoopAutoStarterFactory::class,
        ILoopFactory::class => LoopFactory::class,
        ILegacySettingsProviderBuilder::class => LegacySettingsProviderBuilder::class,
        ISignalHandlersSetup::class => SignalHandlersSetup::class,
        ISignalHandlersSetupBuilder::class => SignalHandlersSetupBuilder::class,
        ISignalHandlersSetupFactory::class => SignalHandlersSetupFactory::class,
        ISpinnerFactory::class => SpinnerFactory::class,
        IStyleFrameRevolverFactory::class => StyleFrameRevolverFactory::class,
        ITimerBuilder::class => TimerBuilder::class,
        ITimerFactory::class => TimerFactory::class,
        IWidgetBuilder::class => WidgetBuilder::class,
        IWidgetCompositeBuilder::class => WidgetCompositeBuilder::class,
        IWidgetFactory::class => WidgetFactory::class,
        IWidgetCompositeFactory::class => WidgetCompositeFactory::class,
        IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
        IWidgetRevolverFactory::class => WidgetRevolverFactory::class,
        ILegacyWidgetSettingsBuilder::class => LegacyWidgetSettingsBuilder::class,
        ILegacyWidgetSettingsFactory::class => LegacyWidgetSettingsFactory::class,

        IDriver::class => static function (ContainerInterface $container): IDriver {
            return $container->get(IDriverFactory::class)->getDriver();
        },
        IDriverLinker::class => static function (ContainerInterface $container): IDriverLinker {
            return $container->get(IDriverLinkerFactory::class)->getDriverLinker();
        },
        ILegacyDriverSettings::class => static function (ContainerInterface $container): ILegacyDriverSettings {
            return $container->get(ILegacySettingsProvider::class)->getLegacyDriverSettings();
        },
        IIntervalNormalizer::class => static function (ContainerInterface $container): IIntervalNormalizer {
            return $container->get(IIntervalNormalizerFactory::class)->create();
        },
        ILoop::class => static function (ContainerInterface $container): ILoop {
            return $container->get(ILoopFactory::class)->getLoop();
        },

        ILoopProbe::class => static function (ContainerInterface $container): ILoopProbe {
            return $container->get(ILoopProbeFactory::class)->getProbe();
        },
        ILoopSettingsFactory::class => static function (ContainerInterface $container): ILoopSettingsFactory {
            $loopProbe = null;
            $signalProcessingProbe = null;
            try {
                $loopProbe = $container->get(ILoopProbeFactory::class)->getProbe();
                $signalProcessingProbe = $container->get(ISignalProcessingProbeFactory::class)->getProbe();
            } finally {
                return new LoopSettingsFactory(
                    $loopProbe,
                    $signalProcessingProbe
                );
            }
        },

        IResourceStream::class => static function (ContainerInterface $container): IResourceStream {
            /** @var ILegacySettingsProvider $provider */
            $provider = $container->get(ILegacySettingsProvider::class);
            return
                new ResourceStream($provider->getLegacyTerminalSettings()->getOutputStream());
        },

        ISettingsProvider::class => static function (ContainerInterface $container): ISettingsProvider {
            return $container->get(ISettingsProviderFactory::class)->create();
        },
        ISettingsProviderFactory::class => SettingsProviderFactory::class,
        ISettingsProviderBuilder::class => SettingsProviderBuilder::class,
        IUserSettingsFactory::class => UserSettingsFactory::class,
        IDetectedSettingsFactory::class => DetectedSettingsFactory::class,
        IDefaultSettingsFactory::class => DefaultSettingsFactory::class,

        ILegacySettingsProvider::class => static function (ContainerInterface $container): ILegacySettingsProvider {
            return
                $container->get(ILegacySettingsProviderBuilder::class)->build();
        },
        ISignalProcessingProbe::class => static function (ContainerInterface $container): ISignalProcessingProbe {
            return
                $container->get(ISignalProcessingProbeFactory::class)->getProbe();
        },
        ISignalProcessingProbeFactory::class => SignalProcessingProbeFactory::class,

        ITerminalProbeFactory::class => static function (): ITerminalProbeFactory {
            return
                new TerminalProbeFactory(
                    new ArrayObject([
                        NativeTerminalProbe::class,
                    ]),
                );
        },
        ITerminalSettingsFactory::class => static function (ContainerInterface $container
        ): ITerminalSettingsFactory {
            $terminalProbe = $container->get(ITerminalProbeFactory::class)->getProbe();

            return
                new TerminalSettingsFactory($terminalProbe);
        },

        NormalizerMethodMode::class => static function (ContainerInterface $container): NormalizerMethodMode {
            return
                NormalizerMethodMode::BALANCED; // FIXME (2023-09-29 13:57) [Alec Rabbit]: stub!
        },
        CursorVisibilityOption::class => static function (ContainerInterface $container): CursorVisibilityOption {
            return
                $container->get(ILegacySettingsProvider::class)->getLegacyTerminalSettings()->getOptionCursor();
        },
        StylingMethodOption::class => static function (ContainerInterface $container): StylingMethodOption {
            return
                $container->get(ILegacySettingsProvider::class)->getLegacyTerminalSettings()->getOptionStyleMode();
        },

        ILoopProbeFactory::class => static function (): ILoopProbeFactory {
            return
                new LoopProbeFactory(
                    Probes::load(ILoopProbe::class)
                );
        },

        IPatternFactory::class => PatternFactory::class,
        IPaletteModeFactory::class => PaletteModeFactory::class,
        ILoopAvailabilityDetector::class => LoopAvailabilityDetector::class,

    ];
    yield from substitutes();
}

function substitutes(): Traversable
{
    yield from [

        IAuxConfigFactory::class => static function (): IAuxConfigFactory {
            return
                new class implements IAuxConfigFactory {
                    public function create(): IAuxConfig
                    {
                        return
                            new AuxConfig(
                                runMethodMode: RunMethodMode::ASYNC,
                                normalizerMethodMode: NormalizerMethodMode::BALANCED,
                            );
                    }
                };
        },
        ILoopConfigFactory::class => static function (): ILoopConfigFactory {
            return
                new class implements ILoopConfigFactory {
                    public function create(): ILoopConfig
                    {
                        return
                            new LoopConfig(
                                autoStartMode: AutoStartMode::ENABLED,
                                signalHandlersMode: SignalHandlersMode::ENABLED,
                            );
                    }
                };
        },
        IDriverConfigFactory::class => static function (): IDriverConfigFactory {
            return
                new class implements IDriverConfigFactory {
                    public function create(): IDriverConfig
                    {
                        return
                            new DriverConfig(
                                linkerMode: LinkerMode::ENABLED,
                                initializationMode: InitializationMode::ENABLED,
                            );
                    }
                };
        },
        IOutputConfigFactory::class => static function (): IOutputConfigFactory {
            return
                new class implements IOutputConfigFactory {
                    public function create(): IOutputConfig
                    {
                        return
                            new OutputConfig(
                                stylingMethodMode: StylingMethodMode::ANSI8,
                                cursorVisibilityMode: CursorVisibilityMode::HIDDEN,
                            );
                    }
                };
        },
//        IWidgetConfigFactory::class => static function (): IWidgetConfigFactory {
//            return
//                new class implements IWidgetConfigFactory {
//                    public function create(
//                        ?\AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings $widgetSettings = null
//                    ): \AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig {
//                        return
//                            new \AlecRabbit\Spinner\Core\Config\WidgetConfig(
//                                leadingSpacer: new \AlecRabbit\Spinner\Core\CharFrame('', 0),
//                                trailingSpacer: new \AlecRabbit\Spinner\Core\CharFrame(' ', 1),
//                                revolverConfig: new \AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig(
//                                    stylePalette: new \AlecRabbit\Spinner\Core\Palette\NoStylePalette(),
//                                    charPalette: new \AlecRabbit\Spinner\Core\Palette\NoCharPalette(),
//                                )
//                            );
//                    }
//                };
//        },
        IWidgetConfigFactory::class => static function (): IRootWidgetConfigFactory {
            return
                new class implements IRootWidgetConfigFactory {
                    public function create(
                        ?IWidgetSettings $widgetSettings = null
                    ): IRootWidgetConfig {
                        return
                            new RootWidgetConfig(
                                leadingSpacer: new CharFrame('', 0),
                                trailingSpacer: new CharFrame(' ', 1),
                                revolverConfig: new WidgetRevolverConfig(
                                    stylePalette: new Rainbow(),
                                    charPalette: new Snake(),
                                )
                            );
                    }
                };
        },
        IRootWidgetConfigFactory::class => static function (): IRootWidgetConfigFactory {
            return
                new class implements IRootWidgetConfigFactory {
                    public function create(
                        ?IWidgetSettings $widgetSettings = null
                    ): IRootWidgetConfig {
                        return
                            new RootWidgetConfig(
                                leadingSpacer: new CharFrame('', 0),
                                trailingSpacer: new CharFrame(' ', 1),
                                revolverConfig: new WidgetRevolverConfig(
                                    stylePalette: new Rainbow(),
                                    charPalette: new Snake(),
                                )
                            );
                    }
                };
        },
        IColorSupportDetector::class => static function (): IColorSupportDetector {
            return
                new class implements IColorSupportDetector {
                    public function getStylingMethodOption(): StylingMethodOption
                    {
                        return StylingMethodOption::ANSI24;
                    }
                };
        },
        ISignalHandlingDetector::class => static function (): ISignalHandlingDetector {
            return
                new class implements ISignalHandlingDetector {
                    public function isSupported(): true
                    {
                        return true;
                    }
                };
        },
    ];
}
// @codeCoverageIgnoreEnd
