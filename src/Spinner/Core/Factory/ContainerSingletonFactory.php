<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Spinner\Contract\Color\Style\IStyleOptionsParser;
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
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\DefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\DriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\TimerBuilder;
use AlecRabbit\Spinner\Core\Builder\WidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Color\Style\StyleOptionsParser;
use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\DriverSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IContainerSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Render\CharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Render\CharFrameRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Render\StyleFrameCollectionRenderer;
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
use ArrayObject;
use Psr\Container\ContainerInterface;
use Traversable;

final class ContainerSingletonFactory implements IContainerSingletonFactory
{
    private static ?IContainer $container = null;

    public static function getContainer(): IContainer
    {
        return self::createContainer();
    }

    private static function createContainer(): IContainer
    {
        if (self::$container === null) {
            self::$container = new Container(
                spawnerCreatorCb: static function (ContainerInterface $container): IServiceSpawner {
                    return new ServiceSpawner($container);
                },
            );
            self::initializeContainer(self::$container);
        }

        return self::$container;
    }

    private static function initializeContainer(IContainer $container): void
    {
        foreach (self::getDefaultDefinitions() as $id => $service) {
            $container->add($id, $service);
        }
    }

    private static function getDefaultDefinitions(): Traversable
    {
        // TODO (2023-04-10 20:21) [Alec Rabbit]: consider extracting definitions?
        yield from [
            IAnsiColorParserFactory::class => AnsiColorParserFactory::class,
            IAuxSettingsBuilder::class => AuxSettingsBuilder::class,
            IBufferedOutputBuilder::class => BufferedOutputBuilder::class,
            IBufferedOutputSingletonFactory::class => BufferedOutputSingletonFactory::class,
            ICharFrameCollectionRenderer::class => CharFrameCollectionRenderer::class,
            ICharFrameRenderer::class => CharFrameRenderer::class,
            ICharFrameRevolverFactory::class => CharFrameRevolverFactory::class,
            IConsoleCursorBuilder::class => ConsoleCursorBuilder::class,
            IConsoleCursorFactory::class => ConsoleCursorFactory::class,
            IDefaultsProviderBuilder::class => DefaultsProviderBuilder::class,
            IDriverLinkerSingletonFactory::class => DriverLinkerSingletonFactory::class,
            IDriverBuilder::class => DriverBuilder::class,
            IDriverOutputBuilder::class => DriverOutputBuilder::class,
            IDriverOutputFactory::class => DriverOutputFactory::class,
            IDriverSettingsBuilder::class => DriverSettingsBuilder::class,
            IDriverSetup::class => DriverSetup::class,
            IDriverSingletonFactory::class => DriverSingletonFactory::class,
            IFrameFactory::class => FrameFactory::class,
            IFrameRevolverBuilder::class => FrameRevolverBuilder::class,
            IHexColorToAnsiCodeConverterFactory::class => HexColorToAnsiCodeConverterFactory::class,
            IIntegerNormalizerBuilder::class => IntegerNormalizerBuilder::class,
            IIntervalFactory::class => IntervalFactory::class,
            IIntervalNormalizerFactory::class => IntervalNormalizerFactory::class,
            ILoopSetup::class => LoopSetup::class,
            ILoopSetupBuilder::class => LoopSetupBuilder::class,
            ILoopSetupFactory::class => LoopSetupFactory::class,
            ILoopSingletonFactory::class => LoopSingletonFactory::class,
            ISpinnerFactory::class => SpinnerFactory::class,
            IStyleFactory::class => StyleFactory::class,
            IStyleFrameCollectionRenderer::class => StyleFrameCollectionRenderer::class,
            IStyleFrameRendererFactory::class => StyleFrameRendererFactory::class,
            IStyleOptionsParser::class => StyleOptionsParser::class,
            IStyleRendererFactory::class => StyleRendererFactory::class,
            IStyleFrameRevolverFactory::class => StyleFrameRevolverFactory::class,
            IStyleToAnsiStringConverterFactory::class => StyleToAnsiStringConverterFactory::class,
            ITimerBuilder::class => TimerBuilder::class,
            ITimerFactory::class => TimerFactory::class,
            IWidgetBuilder::class => WidgetBuilder::class,
            IWidgetFactory::class => WidgetFactory::class,
            IWidgetSettingsFactory::class => WidgetSettingsFactory::class,
            IWidgetRevolverBuilder::class => WidgetRevolverBuilder::class,
            IWidgetRevolverFactory::class => WidgetRevolverFactory::class,
            IWidgetSettingsBuilder::class => WidgetSettingsBuilder::class,
            IWidthMeasurerFactory::class => WidthMeasurerFactory::class,

            IDefaultsProvider::class => static function (ContainerInterface $container): IDefaultsProvider {
                return $container->get(IDefaultsProviderBuilder::class)->build();
            },
            IDriver::class => static function (ContainerInterface $container): IDriver {
                return $container->get(IDriverSingletonFactory::class)->getDriver();
            },
            IDriverLinker::class => static function (ContainerInterface $container): IDriverLinker {
                return $container->get(IDriverLinkerSingletonFactory::class)->getDriverLinker();
            },
            IDriverSettings::class => static function (ContainerInterface $container): IDriverSettings {
                return $container->get(IDefaultsProvider::class)->getDriverSettings();
            },
            IIntervalNormalizer::class => static function (ContainerInterface $container): IIntervalNormalizer {
                return $container->get(IIntervalNormalizerFactory::class)->create();
            },
            ILoop::class => static function (ContainerInterface $container): ILoop {
                return $container->get(ILoopSingletonFactory::class)->getLoop();
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
            ISignalProcessingProbe::class => static function (ContainerInterface $container): ISignalProcessingProbe {
                return $container->get(ISignalProcessingProbeFactory::class)->getProbe();
            },
            ISignalProcessingProbeFactory::class => SignalProcessingProbeFactory::class,
            IResourceStream::class => static function (ContainerInterface $container): IResourceStream {
                /** @var IDefaultsProvider $provider */
                $provider = $container->get(IDefaultsProvider::class);
                return new ResourceStream($provider->getTerminalSettings()->getOutputStream());
            },
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
                return $container->get(IDefaultsProvider::class)->getAuxSettings()->getOptionNormalizerMode();
            },
            OptionCursor::class => static function (ContainerInterface $container): OptionCursor {
                return $container->get(IDefaultsProvider::class)->getTerminalSettings()->getOptionCursor();
            },
            OptionStyleMode::class => static function (ContainerInterface $container): OptionStyleMode {
                return $container->get(IDefaultsProvider::class)->getTerminalSettings()->getOptionStyleMode();
            },
        ];
    }
}
