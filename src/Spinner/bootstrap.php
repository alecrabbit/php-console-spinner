<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Builder\BufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Builder\DriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\IntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\LoopSetupBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\AuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\DriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\SettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\TimerBuilder;
use AlecRabbit\Spinner\Core\Builder\WidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\DriverSetup;
use AlecRabbit\Spinner\Core\Factory\BufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Core\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Spinner\Core\Factory\FrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\LoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\LoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Factory\SignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\TerminalProbeFactory;
use AlecRabbit\Spinner\Core\Factory\TerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\TimerFactory;
use AlecRabbit\Spinner\Core\Factory\WidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\WidthMeasurerFactory;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Terminal\NativeTerminalProbe;
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

// @codeCoverageIgnoreStart

$definitions = DefinitionRegistry::getInstance();

foreach (definitions() as $id => $definition) {
    $definitions->bind($id, $definition);
}

function definitions(): Traversable
{
    yield from [
        IAuxSettingsBuilder::class => AuxSettingsBuilder::class,
        IBufferedOutputBuilder::class => BufferedOutputBuilder::class,
        IBufferedOutputSingletonFactory::class => BufferedOutputSingletonFactory::class,
        ICharFrameFactory::class => CharFrameFactory::class,
        ICharFrameRevolverFactory::class => CharFrameRevolverFactory::class,
        IConsoleCursorBuilder::class => ConsoleCursorBuilder::class,
        IConsoleCursorFactory::class => ConsoleCursorFactory::class,
        IDriverBuilder::class => DriverBuilder::class,
        IDriverFactory::class => DriverFactory::class,
        IDriverLinkerFactory::class => DriverLinkerFactory::class,
        IDriverOutputBuilder::class => DriverOutputBuilder::class,
        IDriverOutputFactory::class => DriverOutputFactory::class,
        IDriverSettingsBuilder::class => DriverSettingsBuilder::class,
        IDriverSetup::class => DriverSetup::class,
        IFrameCollectionFactory::class => FrameCollectionFactory::class,
        IFrameRevolverBuilder::class => FrameRevolverBuilder::class,
        IIntegerNormalizerBuilder::class => IntegerNormalizerBuilder::class,
        IIntervalFactory::class => IntervalFactory::class,
        IIntervalNormalizerFactory::class => IntervalNormalizerFactory::class,
        ILoopFactory::class => LoopFactory::class,
        ILoopSetup::class => LoopSetup::class,
        ILoopSetupBuilder::class => LoopSetupBuilder::class,
        ILoopSetupFactory::class => LoopSetupFactory::class,
        ISettingsProviderBuilder::class => SettingsProviderBuilder::class,
        ISpinnerFactory::class => SpinnerFactory::class,
        IStyleFrameFactory::class => StyleFrameFactory::class,
        IStyleFrameRevolverFactory::class => StyleFrameRevolverFactory::class,
        ITimerBuilder::class => TimerBuilder::class,
        ITimerFactory::class => TimerFactory::class,
        IWidgetBuilder::class => WidgetBuilder::class,
        IWidgetFactory::class => WidgetFactory::class,
        IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
        IWidgetRevolverFactory::class => WidgetRevolverFactory::class,
        IWidgetSettingsBuilder::class => WidgetSettingsBuilder::class,
        IWidgetSettingsFactory::class => WidgetSettingsFactory::class,
        IWidthMeasurerFactory::class => WidthMeasurerFactory::class,

        IDriver::class => static function (ContainerInterface $container): IDriver {
            return $container->get(IDriverFactory::class)->getDriver();
        },
        IDriverLinker::class => static function (ContainerInterface $container): IDriverLinker {
            return $container->get(IDriverLinkerFactory::class)->getDriverLinker();
        },
        IDriverSettings::class => static function (ContainerInterface $container): IDriverSettings {
            return $container->get(ISettingsProvider::class)->getDriverSettings();
        },
        IIntervalNormalizer::class => static function (ContainerInterface $container): IIntervalNormalizer {
            return $container->get(IIntervalNormalizerFactory::class)->create();
        },
        ILoop::class => static function (ContainerInterface $container): ILoop {
            return $container->get(ILoopFactory::class)->getLoop();
        },
        ILoopProbeFactory::class => static function (): never {
            throw new DomainException(
                sprintf(
                    'Service for id [%s] is not available in this context.',
                    ILoopProbeFactory::class
                )
            );
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
            /** @var ISettingsProvider $provider */
            $provider = $container->get(ISettingsProvider::class);
            return new ResourceStream($provider->getTerminalSettings()->getOutputStream());
        },

        ISettingsProvider::class => static function (ContainerInterface $container): ISettingsProvider {
            return $container->get(ISettingsProviderBuilder::class)->build();
        },
        ISignalProcessingProbe::class => static function (ContainerInterface $container): ISignalProcessingProbe {
            return $container->get(ISignalProcessingProbeFactory::class)->getProbe();
        },
        ISignalProcessingProbeFactory::class => SignalProcessingProbeFactory::class,

        ITerminalProbeFactory::class => static function (): ITerminalProbeFactory {
            return new TerminalProbeFactory(
                new ArrayObject([
                    NativeTerminalProbe::class,
                ]),
            );
        },
        ITerminalSettingsFactory::class => static function (ContainerInterface $container
        ): ITerminalSettingsFactory {
            $terminalProbe = $container->get(ITerminalProbeFactory::class)->getProbe();

            return new TerminalSettingsFactory($terminalProbe);
        },

        IWidthMeasurer::class => static function (ContainerInterface $container): IWidthMeasurer {
            return $container->get(IWidthMeasurerFactory::class)->create();
        },

        OptionNormalizerMode::class => static function (ContainerInterface $container): OptionNormalizerMode {
            return $container->get(ISettingsProvider::class)->getAuxSettings()->getOptionNormalizerMode();
        },
        OptionCursor::class => static function (ContainerInterface $container): OptionCursor {
            return $container->get(ISettingsProvider::class)->getTerminalSettings()->getOptionCursor();
        },
        OptionStyleMode::class => static function (ContainerInterface $container): OptionStyleMode {
            return $container->get(ISettingsProvider::class)->getTerminalSettings()->getOptionStyleMode();
        },
    ];
}
// @codeCoverageIgnoreEnd
