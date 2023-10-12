<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;
use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Builder\BufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\IntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\TimerBuilder;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Config\Builder\AuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\DriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\LoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\OutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\WidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IAuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigProviderFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRuntimeRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRuntimeWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\AuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\ConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\ConfigProviderFactory;
use AlecRabbit\Spinner\Core\Config\Factory\DriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\LoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\OutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\RuntimeRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\RuntimeWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\WidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\RootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Solver\AutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IInitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILinkerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\CursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\InitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\LinkerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\NormalizerMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\RunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\SignalHandlersModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\StylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\BufferedOutputFactory;
use AlecRabbit\Spinner\Core\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\DriverProviderFactory;
use AlecRabbit\Spinner\Core\Factory\FrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\TimerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassExtractor;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Loop\Factory\LoopProviderFactory;
use AlecRabbit\Spinner\Core\Loop\LoopCreatorClassExtractor;
use AlecRabbit\Spinner\Core\Loop\LoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Loop\LoopSetup;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\PaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\PatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Settings\Builder\SettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IColorSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalProcessingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Detector\ColorSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\LoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\SignalProcessingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Factory\DefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\DetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\SettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\UserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
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
use Psr\Container\ContainerInterface;
use Traversable;

// @codeCoverageIgnoreStart
function getDefinitions(): Traversable
{
    yield from [
        IResourceStream::class => static function (ContainerInterface $container): IResourceStream {
            return
                new ResourceStream(STDERR); // FIXME (2023-10-11 14:49) [Alec Rabbit]: stub!
        },
        ISettingsProvider::class => static function (ContainerInterface $container): ISettingsProvider {
            return $container->get(ISettingsProviderFactory::class)->create();
        },
        IConfigProvider::class => static function (ContainerInterface $container): IConfigProvider {
            return $container->get(IConfigProviderFactory::class)->create();
        },
        ILoopProvider::class => static function (ContainerInterface $container): ILoopProvider {
            return $container->get(ILoopProviderFactory::class)->create();
        },
        IDriverProvider::class => static function (ContainerInterface $container): IDriverProvider {
            return $container->get(IDriverProviderFactory::class)->create();
        },

        IDriver::class => static function (ContainerInterface $container): IDriver {
            return $container->get(IDriverFactory::class)->getDriver();
        },
        IDriverLinker::class => static function (ContainerInterface $container): IDriverLinker {
            return $container->get(IDriverLinkerFactory::class)->create();
        },
        IIntervalNormalizer::class => static function (ContainerInterface $container): IIntervalNormalizer {
            return $container->get(IIntervalNormalizerFactory::class)->create();
        },
        ILoopCreatorClassProvider::class => static function (ContainerInterface $container): ILoopCreatorClassProvider {
            $creatorClass = $container->get(ILoopCreatorClassExtractor::class)->extract(
                Probes::load(ILoopProbe::class)
            );
            return
                new LoopCreatorClassProvider(
                    $creatorClass,
                );
        },
        ILoopCreatorClassExtractor::class => LoopCreatorClassExtractor::class,
        ILoopSetup::class => LoopSetup::class,
    ];

    yield from configs();
    yield from builders();
    yield from solvers();
    yield from factories();
    yield from detectors();

    // to be removed:
    yield from substitutes();
    yield from legacy();
}

// parts of definitions:
function configs(): Traversable
{
    yield from [
        IConfig::class => static function (ContainerInterface $container): IConfig {
            return $container->get(IConfigProvider::class)->getConfig();
        },
        IDriverConfig::class => static function (ContainerInterface $container): IDriverConfig {
            return $container->get(IConfig::class)->get(IDriverConfig::class);
        },
        IOutputConfig::class => static function (ContainerInterface $container): IOutputConfig {
            return $container->get(IConfig::class)->get(IOutputConfig::class);
        },
        ILoopConfig::class => static function (ContainerInterface $container): ILoopConfig {
            return $container->get(IConfig::class)->get(ILoopConfig::class);
        },
        IAuxConfig::class => static function (ContainerInterface $container): IAuxConfig {
            return $container->get(IConfig::class)->get(IAuxConfig::class);
        },
        IWidgetConfig::class => static function (ContainerInterface $container): IWidgetConfig {
            return $container->get(IConfig::class)->get(IWidgetConfig::class);
        },
        IRootWidgetConfig::class => static function (ContainerInterface $container): IRootWidgetConfig {
            return $container->get(IConfig::class)->get(IRootWidgetConfig::class);
        },
    ];
}

function builders(): Traversable
{
    yield from [
        IDriverBuilder::class => DriverBuilder::class,
        IDriverOutputBuilder::class => DriverOutputBuilder::class,
        IFrameRevolverBuilder::class => FrameRevolverBuilder::class,
        IIntegerNormalizerBuilder::class => IntegerNormalizerBuilder::class,
        ITimerBuilder::class => TimerBuilder::class,
        IWidgetBuilder::class => WidgetBuilder::class,
        IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
        IWidgetCompositeBuilder::class => WidgetCompositeBuilder::class,
        IBufferedOutputBuilder::class => BufferedOutputBuilder::class,
        IConsoleCursorBuilder::class => ConsoleCursorBuilder::class,
        ISettingsProviderBuilder::class => SettingsProviderBuilder::class,

        IAuxConfigBuilder::class => AuxConfigBuilder::class,
        ILoopConfigBuilder::class => LoopConfigBuilder::class,
        IOutputConfigBuilder::class => OutputConfigBuilder::class,
        IDriverConfigBuilder::class => DriverConfigBuilder::class,
        IWidgetConfigBuilder::class => WidgetConfigBuilder::class,
    ];
}

function solvers(): Traversable
{
    yield from [
        IRunMethodModeSolver::class => RunMethodModeSolver::class,
        INormalizerMethodModeSolver::class => NormalizerMethodModeSolver::class,
        IAutoStartModeSolver::class => AutoStartModeSolver::class,
        ISignalHandlersModeSolver::class => SignalHandlersModeSolver::class,
        IStylingMethodModeSolver::class => StylingMethodModeSolver::class,
        ICursorVisibilityModeSolver::class => CursorVisibilityModeSolver::class,
        ILinkerModeSolver::class => LinkerModeSolver::class,
        IInitializationModeSolver::class => InitializationModeSolver::class,
    ];
}

function factories(): Traversable
{
    yield from [
        IDriverFactory::class => DriverFactory::class,
        ILoopProviderFactory::class => LoopProviderFactory::class,
        IDriverProviderFactory::class => DriverProviderFactory::class,

        IBufferedOutputFactory::class => BufferedOutputFactory::class,
        ICharFrameRevolverFactory::class => CharFrameRevolverFactory::class,
        IConfigFactory::class => ConfigFactory::class,
        IConfigProviderFactory::class => ConfigProviderFactory::class,
        IConsoleCursorFactory::class => ConsoleCursorFactory::class,
        IDefaultSettingsFactory::class => DefaultSettingsFactory::class,
        IDetectedSettingsFactory::class => DetectedSettingsFactory::class,
        IDriverLinkerFactory::class => DriverLinkerFactory::class,
        IDriverOutputFactory::class => DriverOutputFactory::class,
        IFrameCollectionFactory::class => FrameCollectionFactory::class,
        IIntervalFactory::class => IntervalFactory::class,
        IIntervalNormalizerFactory::class => IntervalNormalizerFactory::class,
        ISettingsProviderFactory::class => SettingsProviderFactory::class,
        ISpinnerFactory::class => SpinnerFactory::class,
        IStyleFrameRevolverFactory::class => StyleFrameRevolverFactory::class,
        ITimerFactory::class => TimerFactory::class,
        IUserSettingsFactory::class => UserSettingsFactory::class,
        IWidgetCompositeFactory::class => WidgetCompositeFactory::class,
        IWidgetFactory::class => WidgetFactory::class,
        IWidgetRevolverFactory::class => WidgetRevolverFactory::class,

        IPatternFactory::class => PatternFactory::class,
        IPaletteModeFactory::class => PaletteModeFactory::class,

        IAuxConfigFactory::class => AuxConfigFactory::class,
        ILoopConfigFactory::class => LoopConfigFactory::class,


        IOutputConfigFactory::class => OutputConfigFactory::class,
        IDriverConfigFactory::class => DriverConfigFactory::class,

        ILoopFactory::class => static function (ContainerInterface $container): ILoopFactory {
            return
                new LoopFactory(
                    loopCreator: (string)$container->get(ILoopCreatorClassProvider::class)->getCreatorClass(),
                );
        },

        IRuntimeWidgetConfigFactory::class => RuntimeWidgetConfigFactory::class,
        IRuntimeRootWidgetConfigFactory::class => RuntimeRootWidgetConfigFactory::class,
    ];
}

function detectors(): Traversable
{
    yield from [
        ILoopSupportDetector::class => static function (ContainerInterface $container): LoopSupportDetector {
            return
                new LoopSupportDetector(
                    $container->get(ILoopCreatorClassProvider::class)->getCreatorClass(),
                );
        },
        ISignalProcessingSupportDetector::class => static function (): SignalProcessingSupportDetector {
            return
                new SignalProcessingSupportDetector(
                    Probes::load(ISignalProcessingProbe::class)
                );
        },
        IColorSupportDetector::class => static function (): IColorSupportDetector {
            return
                new ColorSupportDetector(
                    Probes::load(IColorSupportProbe::class)
                );
        },
    ];
}

/*
 * FUNCTIONS TO BE REMOVED:
 */
function substitutes(): Traversable
{
    yield from [
        IWidgetSettingsSolver::class => static function (): IWidgetSettingsSolver {
            return new class implements IWidgetSettingsSolver {
                public function solve(): IWidgetSettings
                {
                    return
                        new WidgetSettings(
                            leadingSpacer: new CharFrame('', 0),
                            trailingSpacer: new CharFrame(' ', 1),
                            stylePalette: new NoStylePalette(),
                            charPalette: new NoCharPalette(),
                        );
                }
            };
        },
        IWidgetConfigFactory::class => WidgetConfigFactory::class,
//        IWidgetConfigFactory::class => static function (): IWidgetConfigFactory {
//            return
//                new class implements IWidgetConfigFactory {
//                    public function create(
//                        ?IWidgetSettings $widgetSettings = null
//                    ): IWidgetConfig {
//                        return
//                            new WidgetConfig(
//                                leadingSpacer: new CharFrame('', 0),
//                                trailingSpacer: new CharFrame(' ', 1),
//                                revolverConfig: new WidgetRevolverConfig(
//                                    stylePalette: new NoStylePalette(),
//                                    charPalette: new NoCharPalette(),
//                                )
//                            );
//                    }
//                };
//        },
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
        NormalizerMethodMode::class => static function (ContainerInterface $container): NormalizerMethodMode {
            return
                NormalizerMethodMode::BALANCED; // FIXME (2023-09-29 13:57) [Alec Rabbit]: stub!
        },
    ];
}

function legacy(): Traversable
{
    yield from [
//        ILegacyAuxSettingsBuilder::class => LegacyAuxSettingsBuilder::class,
//        ILegacyDriverSettingsBuilder::class => LegacyDriverSettingsBuilder::class,
//        ILegacySettingsProviderBuilder::class => LegacySettingsProviderBuilder::class,
//        ILegacyWidgetSettingsBuilder::class => LegacyWidgetSettingsBuilder::class,
//        ILegacyWidgetSettingsFactory::class => LegacyWidgetSettingsFactory::class,
//        ILegacyDriverSettings::class => static function (ContainerInterface $container): ILegacyDriverSettings {
//            return $container->get(ILegacySettingsProvider::class)->getLegacyDriverSettings();
//        },
//        ILegacySignalProcessingProbeFactory::class => LegacySignalProcessingProbeFactory::class,
//
//        ILegacyTerminalProbeFactory::class => static function (): ILegacyTerminalProbeFactory {
//            return
//                new LegacyTerminalProbeFactory(
//                    new ArrayObject([
//                        NativeTerminalLegacyProbe::class,
//                    ]),
//                );
//        },
//        ILoopSettingsFactory::class => static function (ContainerInterface $container): ILoopSettingsFactory {
//            $loopProbe = null;
//            $signalProcessingProbe = null;
//            try {
//                $loopProbe = $container->get(ILegacyLoopProbeFactory::class)->getProbe();
//                $signalProcessingProbe = $container->get(ILegacySignalProcessingProbeFactory::class)->getProbe();
//            } finally {
//                return new LoopSettingsFactory(
//                    $loopProbe,
//                    $signalProcessingProbe
//                );
//            }
//        },
//        ILegacySettingsProvider::class => static function (ContainerInterface $container): ILegacySettingsProvider {
//            return
//                $container->get(ILegacySettingsProviderBuilder::class)->build();
//        },
//        ILegacySignalProcessingLegacyProbe::class => static function (ContainerInterface $container
//        ): ILegacySignalProcessingLegacyProbe {
//            return
//                $container->get(ILegacySignalProcessingProbeFactory::class)->getProbe();
//        },
//        ILegacyTerminalSettingsFactory::class => static function (ContainerInterface $container
//        ): ILegacyTerminalSettingsFactory {
//            $terminalProbe = $container->get(ILegacyTerminalProbeFactory::class)->getProbe();
//
//            return
//                new LegacyTerminalSettingsFactory($terminalProbe);
//        },
//        ILegacySignalHandlersSetup::class => LegacySignalHandlersSetup::class,
//        ILegacyLoopAutoStarterBuilder::class => LegacyLoopAutoStarterBuilder::class,
//        ILegacyLoopAutoStarterFactory::class => LegacyLoopAutoStarterFactory::class,
    ];
}
// @codeCoverageIgnoreEnd
