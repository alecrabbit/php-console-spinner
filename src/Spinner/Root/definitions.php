<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Root;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\INowTimer;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;
use AlecRabbit\Spinner\Core\Builder\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateWriterBuilder;
use AlecRabbit\Spinner\Core\Builder\DeltaTimerBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Builder\IntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\SequenceStateBuilder;
use AlecRabbit\Spinner\Core\Builder\SequenceStateWriterBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\DriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\GeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\LinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\LoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\NormalizerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\OutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\RevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IGeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\INormalizerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IGeneralConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IInitialRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IInitialWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILinkerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\INormalizerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRevolverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Factory\DriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\GeneralConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\InitialRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\InitialWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\LinkerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\LoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\NormalizerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\OutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\RevolverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\RootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Factory\WidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\AutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverMessagesSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IInitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILinkerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlingModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStreamSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IToleranceSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\CursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\DriverMessagesSolver;
use AlecRabbit\Spinner\Core\Config\Solver\DriverModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\InitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\LinkerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\NormalizerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\RootWidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Config\Solver\RunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\SignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\Config\Solver\SignalHandlingModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\StreamSolver;
use AlecRabbit\Spinner\Core\Config\Solver\StylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\ToleranceSolver;
use AlecRabbit\Spinner\Core\Config\Solver\WidgetSettingsSolver;
use AlecRabbit\Spinner\Core\Contract\IDisabledDriverDetector;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlingSetup;
use AlecRabbit\Spinner\Core\DisabledDriverDetector;
use AlecRabbit\Spinner\Core\DriverSetup;
use AlecRabbit\Spinner\Core\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateWriterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlingSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\DeltaTimerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverProviderFactory;
use AlecRabbit\Spinner\Core\Factory\FrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\SequenceStateWriterFactory;
use AlecRabbit\Spinner\Core\Factory\SignalHandlingSetupFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\IntervalComparator;
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
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IStylingMethodDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Detector\LoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\SignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\StylingMethodDetector;
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
use AlecRabbit\Spinner\Probes;
use Traversable;

use function hrtime;

// @codeCoverageIgnoreStart
/**
 * @return Traversable<string|int, callable|object|string|IServiceDefinition>
 */
function getDefinitions(): Traversable
{
    yield from [
        new ServiceDefinition(
            IBuffer::class,
            StringBuffer::class,
            IServiceDefinition::SINGLETON,
        ),
        new ServiceDefinition(
            IBufferedOutput::class,
            BufferedOutput::class,
            IServiceDefinition::SINGLETON,
        ),
        new ServiceDefinition(
            IWritableStream::class,
            static function (IContainer $container): IWritableStream {
                return $container->get(IResourceStreamFactory::class)->create();
            },
            IServiceDefinition::SINGLETON,
        ),
        new ServiceDefinition(
            ISettingsProvider::class,
            static function (IContainer $container): ISettingsProvider {
                return $container->get(ISettingsProviderFactory::class)->create();
            },
            IServiceDefinition::SINGLETON,
        ),
        new ServiceDefinition(
            ILoopProvider::class,
            static function (IContainer $container): ILoopProvider {
                return $container->get(ILoopProviderFactory::class)->create();
            },
            IServiceDefinition::SINGLETON,
        ),
        new ServiceDefinition(
            IDriverProvider::class,
            static function (IContainer $container): IDriverProvider {
                return $container->get(IDriverProviderFactory::class)->create();
            },
            IServiceDefinition::SINGLETON,
        ),
        new ServiceDefinition(
            IDriverLinker::class,
            static function (IContainer $container): IDriverLinker {
                return $container->get(IDriverLinkerFactory::class)->create();
            },
            IServiceDefinition::SINGLETON,
        ),
        new ServiceDefinition(
            IDisabledDriverDetector::class,
            DisabledDriverDetector::class,
            IServiceDefinition::SINGLETON,
        ),

        NormalizerMode::class => static function (IContainer $container): NormalizerMode {
            return $container->get(INormalizerConfig::class)->getNormalizerMode();
        },
        INowTimer::class => new class() implements INowTimer {
            public function now(): float
            {
                return hrtime(true) * 1e-6; // returns milliseconds
            }
        },

        IOutput::class => Output::class,
        IDriverSetup::class => DriverSetup::class,
        ISignalHandlingSetup::class => static function (IContainer $container): ISignalHandlingSetup {
            return $container->get(ISignalHandlingSetupFactory::class)->create();
        },

        IIntervalComparator::class => IntervalComparator::class,
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
            return new LoopCreatorClassProvider(
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
        IDriverConfig::class => static function (IContainer $container): IDriverConfig {
            return $container->get(IDriverConfigFactory::class)->create();
        },
        ILinkerConfig::class => static function (IContainer $container): ILinkerConfig {
            return $container->get(ILinkerConfigFactory::class)->create();
        },
        IOutputConfig::class => static function (IContainer $container): IOutputConfig {
            return $container->get(IOutputConfigFactory::class)->create();
        },
        ILoopConfig::class => static function (IContainer $container): ILoopConfig {
            return $container->get(ILoopConfigFactory::class)->create();
        },
        INormalizerConfig::class => static function (IContainer $container): INormalizerConfig {
            return $container->get(INormalizerConfigFactory::class)->create();
        },
        IGeneralConfig::class => static function (IContainer $container): IGeneralConfig {
            return $container->get(IGeneralConfigFactory::class)->create();
        },
        IWidgetConfig::class => static function (IContainer $container): IWidgetConfig {
            return $container->get(IInitialWidgetConfigFactory::class)->create();
        },
        IRootWidgetConfig::class => static function (IContainer $container): IRootWidgetConfig {
            return $container->get(IInitialRootWidgetConfigFactory::class)->create();
        },
        RunMethodMode::class => static function (IContainer $container): RunMethodMode {
            return $container->get(IGeneralConfig::class)->getRunMethodMode();
        },
        IRevolverConfig::class => static function (IContainer $container): IRevolverConfig {
            return $container->get(IRevolverConfigFactory::class)->create();
        },
    ];
}

function builders(): Traversable
{
    yield from [
        IConsoleCursorBuilder::class => ConsoleCursorBuilder::class,
        IDeltaTimerBuilder::class => DeltaTimerBuilder::class,
        IDriverBuilder::class => DriverBuilder::class,
        IDriverConfigBuilder::class => DriverConfigBuilder::class,
        IFrameRevolverBuilder::class => FrameRevolverBuilder::class,
        IGeneralConfigBuilder::class => GeneralConfigBuilder::class,
        IIntegerNormalizerBuilder::class => IntegerNormalizerBuilder::class,
        ILinkerConfigBuilder::class => LinkerConfigBuilder::class,
        ILoopConfigBuilder::class => LoopConfigBuilder::class,
        INormalizerConfigBuilder::class => NormalizerConfigBuilder::class,
        IOutputConfigBuilder::class => OutputConfigBuilder::class,

        IRevolverConfigBuilder::class => RevolverConfigBuilder::class,
        ISequenceStateBuilder::class => SequenceStateBuilder::class,
        ISequenceStateWriterBuilder::class => SequenceStateWriterBuilder::class,
        ISettingsProviderBuilder::class => SettingsProviderBuilder::class,

        IWidgetBuilder::class => WidgetBuilder::class,
        IWidgetCompositeBuilder::class => WidgetCompositeBuilder::class,
        IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
    ];
}

function solvers(): Traversable
{
    yield from [
        IAutoStartModeSolver::class => AutoStartModeSolver::class,
        ICursorVisibilityModeSolver::class => CursorVisibilityModeSolver::class,
        IDriverMessagesSolver::class => DriverMessagesSolver::class,
        IDriverModeSolver::class => DriverModeSolver::class,
        IInitializationModeSolver::class => InitializationModeSolver::class,
        ILinkerModeSolver::class => LinkerModeSolver::class,
        INormalizerModeSolver::class => NormalizerModeSolver::class,
        IRootWidgetSettingsSolver::class => RootWidgetSettingsSolver::class,
        IRunMethodModeSolver::class => RunMethodModeSolver::class,
        ISignalHandlersContainerSolver::class => SignalHandlersContainerSolver::class,
        ISignalHandlingModeSolver::class => SignalHandlingModeSolver::class,
        IStreamSolver::class => StreamSolver::class,
        IStylingMethodModeSolver::class => StylingMethodModeSolver::class,
        IToleranceSolver::class => ToleranceSolver::class,
        IWidgetSettingsSolver::class => WidgetSettingsSolver::class,
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
        IConsoleCursorFactory::class => ConsoleCursorFactory::class,
        IDefaultSettingsFactory::class => DefaultSettingsFactory::class,
        IDetectedSettingsFactory::class => DetectedSettingsFactory::class,
        IDriverLinkerFactory::class => DriverLinkerFactory::class,
        ISignalHandlingSetupFactory::class => SignalHandlingSetupFactory::class,
        ISequenceStateWriterFactory::class => SequenceStateWriterFactory::class,
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

        IGeneralConfigFactory::class => GeneralConfigFactory::class,
        INormalizerConfigFactory::class => NormalizerConfigFactory::class,
        ILoopConfigFactory::class => LoopConfigFactory::class,
        IOutputConfigFactory::class => OutputConfigFactory::class,
        ILinkerConfigFactory::class => LinkerConfigFactory::class,
        IRevolverConfigFactory::class => RevolverConfigFactory::class,

        ILoopFactory::class => LoopFactory::class,

        IInitialWidgetConfigFactory::class => InitialWidgetConfigFactory::class,
        IWidgetConfigFactory::class => WidgetConfigFactory::class,
        IInitialRootWidgetConfigFactory::class => InitialRootWidgetConfigFactory::class,
        IRootWidgetConfigFactory::class => RootWidgetConfigFactory::class,
    ];
}

function detectors(): Traversable
{
    yield from [
        ILoopSupportDetector::class => static function (IContainer $container): LoopSupportDetector {
            return new LoopSupportDetector(
                $container->get(ILoopCreatorClassProvider::class)->getCreatorClass(),
            );
        },
        ISignalHandlingSupportDetector::class => static function (): SignalHandlingSupportDetector {
            return new SignalHandlingSupportDetector(
                Probes::load(ISignalHandlingProbe::class)
            );
        },
        IStylingMethodDetector::class => static function (): IStylingMethodDetector {
            return new StylingMethodDetector(
                Probes::load(IStylingMethodProbe::class)
            );
        },
    ];
}
// @codeCoverageIgnoreEnd
