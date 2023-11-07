<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\INow;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;
use AlecRabbit\Spinner\Core\Builder\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\IntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\DeltaTimerBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\AuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\DriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\LinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\LoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\OutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\WidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IAuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigProviderFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILinkerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRuntimeRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRuntimeWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\AuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\ConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\ConfigProviderFactory;
use AlecRabbit\Spinner\Core\Config\Factory\DriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\LinkerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\LoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\OutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\RootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\RuntimeRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\RuntimeWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\WidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Config\Solver\AutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverMessagesSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IInitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILinkerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlingModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStreamSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\CursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\DriverMessagesSolver;
use AlecRabbit\Spinner\Core\Config\Solver\InitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\LinkerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\NormalizerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\RootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\RunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\SignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\Config\Solver\SignalHandlingModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\StreamSolver;
use AlecRabbit\Spinner\Core\Config\Solver\StylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\WidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlingSetup;
use AlecRabbit\Spinner\Core\DriverSetup;
use AlecRabbit\Spinner\Core\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
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
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlingSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\DriverProviderFactory;
use AlecRabbit\Spinner\Core\Factory\FrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\SignalHandlingSetupFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\DeltaTimerFactory;
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
use AlecRabbit\Spinner\Core\Output\BufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\Factory\IResourceStreamFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\Factory\ResourceStreamFactory;
use AlecRabbit\Spinner\Core\Output\Output;
use AlecRabbit\Spinner\Core\Output\StringBuffer;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\PaletteModeFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\PatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Settings\Builder\SettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IColorSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Detector\ColorSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\LoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\SignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Factory\DefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\DetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\SettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\UserSettingsFactory;
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
use Traversable;

// @codeCoverageIgnoreStart
function getDefinitions(): Traversable
{
    yield from [
        INow::class => new class implements INow {
            public function now(): float
            {
                return
                    hrtime(true) * 1e-6; // returns milliseconds
            }
        },

        IOutput::class => Output::class,
        IBuffer::class => StringBuffer::class,
        IBufferedOutput::class => BufferedOutput::class,
        IWritableStream::class => static function (IContainer $container): IWritableStream {
            return
                $container->get(IResourceStreamFactory::class)->create();
        },
        NormalizerMode::class => static function (IContainer $container): NormalizerMode {
            return
                $container->get(IAuxConfig::class)->getNormalizerMode();
        },
        ISettingsProvider::class => static function (IContainer $container): ISettingsProvider {
            return $container->get(ISettingsProviderFactory::class)->create();
        },
        IConfigProvider::class => static function (IContainer $container): IConfigProvider {
            return $container->get(IConfigProviderFactory::class)->create();
        },
        ILoopProvider::class => static function (IContainer $container): ILoopProvider {
            return $container->get(ILoopProviderFactory::class)->create();
        },
        IDriverProvider::class => static function (IContainer $container): IDriverProvider {
            return $container->get(IDriverProviderFactory::class)->create();
        },

        IDriverSetup::class => DriverSetup::class,
        ISignalHandlingSetup::class => static function (IContainer $container): ISignalHandlingSetup {
            return $container->get(ISignalHandlingSetupFactory::class)->create();
        },
        IDriverLinker::class => static function (IContainer $container): IDriverLinker {
            return $container->get(IDriverLinkerFactory::class)->create();
        },
        IIntervalNormalizer::class => static function (IContainer $container): IIntervalNormalizer {
            return $container->get(IIntervalNormalizerFactory::class)->create();
        },
        ILoopCreatorClassProvider::class => static function (IContainer $container): ILoopCreatorClassProvider {
            $creatorClass =
                $container->get(ILoopCreatorClassExtractor::class)
                    ->extract(
                        Probes::load(ILoopProbe::class)
                    )
            ;
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
}

// parts of definitions:
function configs(): Traversable
{
    yield from [
        IConfig::class => static function (IContainer $container): IConfig {
            return $container->get(IConfigProvider::class)->getConfig();
        },
        IDriverConfig::class => static function (IContainer $container): IDriverConfig {
            return $container->get(IConfig::class)->get(IDriverConfig::class);
        },
        ILinkerConfig::class => static function (IContainer $container): ILinkerConfig {
            return $container->get(IConfig::class)->get(ILinkerConfig::class);
        },
        IOutputConfig::class => static function (IContainer $container): IOutputConfig {
            return $container->get(IConfig::class)->get(IOutputConfig::class);
        },
        ILoopConfig::class => static function (IContainer $container): ILoopConfig {
            return $container->get(IConfig::class)->get(ILoopConfig::class);
        },
        IAuxConfig::class => static function (IContainer $container): IAuxConfig {
            return $container->get(IConfig::class)->get(IAuxConfig::class);
        },
        IWidgetConfig::class => static function (IContainer $container): IWidgetConfig {
            return $container->get(IConfig::class)->get(IWidgetConfig::class);
        },
        IRootWidgetConfig::class => static function (IContainer $container): IRootWidgetConfig {
            return $container->get(IConfig::class)->get(IRootWidgetConfig::class);
        },
        RunMethodMode::class => static function (IContainer $container): RunMethodMode {
            return $container->get(IAuxConfig::class)->getRunMethodMode();
        },
        IRevolverConfig::class => static function (IContainer $container): IRevolverConfig {
            // TODO (2023-04-26 14:21) [Alec Rabbit]: make it configurable [fd86d318-9069-47e2-b60d-a68f537be4a3]
            return new RevolverConfig();
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
        IDeltaTimerBuilder::class => DeltaTimerBuilder::class,
        IWidgetBuilder::class => WidgetBuilder::class,
        IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
        IWidgetCompositeBuilder::class => WidgetCompositeBuilder::class,
        IConsoleCursorBuilder::class => ConsoleCursorBuilder::class,
        ISettingsProviderBuilder::class => SettingsProviderBuilder::class,

        IAuxConfigBuilder::class => AuxConfigBuilder::class,
        IDriverConfigBuilder::class => DriverConfigBuilder::class,
        ILoopConfigBuilder::class => LoopConfigBuilder::class,
        IOutputConfigBuilder::class => OutputConfigBuilder::class,
        ILinkerConfigBuilder::class => LinkerConfigBuilder::class,
        IWidgetConfigBuilder::class => WidgetConfigBuilder::class,
    ];
}

function solvers(): Traversable
{
    yield from [
        IRunMethodModeSolver::class => RunMethodModeSolver::class,
        INormalizerModeSolver::class => NormalizerModeSolver::class,
        IAutoStartModeSolver::class => AutoStartModeSolver::class,
        ISignalHandlingModeSolver::class => SignalHandlingModeSolver::class,
        ISignalHandlersContainerSolver::class => SignalHandlersContainerSolver::class,
        IStylingMethodModeSolver::class => StylingMethodModeSolver::class,
        ICursorVisibilityModeSolver::class => CursorVisibilityModeSolver::class,
        ILinkerModeSolver::class => LinkerModeSolver::class,
        IInitializationModeSolver::class => InitializationModeSolver::class,
        IStreamSolver::class => StreamSolver::class,
        IDriverMessagesSolver::class => DriverMessagesSolver::class,
        IWidgetSettingsSolver::class => WidgetSettingsSolver::class,
        IRootWidgetSettingsSolver::class => RootWidgetSettingsSolver::class,
    ];
}

function factories(): Traversable
{
    yield from [
        IDriverFactory::class => DriverFactory::class,
        IDriverConfigFactory::class => DriverConfigFactory::class,
        ILoopProviderFactory::class => LoopProviderFactory::class,
        IDriverProviderFactory::class => DriverProviderFactory::class,
        IResourceStreamFactory::class => ResourceStreamFactory::class,
        ICharFrameRevolverFactory::class => CharFrameRevolverFactory::class,
        IConfigFactory::class => ConfigFactory::class,
        IConfigProviderFactory::class => ConfigProviderFactory::class,
        IConsoleCursorFactory::class => ConsoleCursorFactory::class,
        IDefaultSettingsFactory::class => DefaultSettingsFactory::class,
        IDetectedSettingsFactory::class => DetectedSettingsFactory::class,
        IDriverLinkerFactory::class => DriverLinkerFactory::class,
        ISignalHandlingSetupFactory::class => SignalHandlingSetupFactory::class,
        IDriverOutputFactory::class => DriverOutputFactory::class,
        IFrameCollectionFactory::class => FrameCollectionFactory::class,
        IIntervalFactory::class => IntervalFactory::class,
        IIntervalNormalizerFactory::class => IntervalNormalizerFactory::class,
        ISettingsProviderFactory::class => SettingsProviderFactory::class,
        ISpinnerFactory::class => SpinnerFactory::class,
        IStyleFrameRevolverFactory::class => StyleFrameRevolverFactory::class,
        IDeltaTimerFactory::class => DeltaTimerFactory::class,
        IUserSettingsFactory::class => UserSettingsFactory::class,
        IWidgetCompositeFactory::class => WidgetCompositeFactory::class,
        IWidgetFactory::class => WidgetFactory::class,
        IWidgetRevolverFactory::class => WidgetRevolverFactory::class,

        IPatternFactory::class => PatternFactory::class,
        IPaletteModeFactory::class => PaletteModeFactory::class,

        IAuxConfigFactory::class => AuxConfigFactory::class,
        ILoopConfigFactory::class => LoopConfigFactory::class,


        IOutputConfigFactory::class => OutputConfigFactory::class,
        ILinkerConfigFactory::class => LinkerConfigFactory::class,
        ILoopFactory::class => LoopFactory::class,

        IWidgetConfigFactory::class => WidgetConfigFactory::class,
        IRootWidgetConfigFactory::class => RootWidgetConfigFactory::class,
        IRuntimeWidgetConfigFactory::class => RuntimeWidgetConfigFactory::class,
        IRuntimeRootWidgetConfigFactory::class => RuntimeRootWidgetConfigFactory::class,
    ];
}

function detectors(): Traversable
{
    yield from [
        ILoopSupportDetector::class => static function (IContainer $container): LoopSupportDetector {
            return
                new LoopSupportDetector(
                    $container->get(ILoopCreatorClassProvider::class)->getCreatorClass(),
                );
        },
        ISignalHandlingSupportDetector::class => static function (): SignalHandlingSupportDetector {
            return
                new SignalHandlingSupportDetector(
                    Probes::load(ISignalHandlingProbe::class)
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
// @codeCoverageIgnoreEnd
