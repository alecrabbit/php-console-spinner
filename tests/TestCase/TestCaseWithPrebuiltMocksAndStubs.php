<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\IDefinitionRegistry;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Pattern\Contract\ICharPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetIntervalContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Extras\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

abstract class TestCaseWithPrebuiltMocksAndStubs extends TestCase
{
    protected function getWidgetConfigStub(): Stub&IWidgetConfig
    {
        return $this->createStub(IWidgetConfig::class);
    }

    protected function createDefinitionRegistryMock(): MockObject&IDefinitionRegistry
    {
        return $this->createMock(IDefinitionRegistry::class);
    }

    protected function getWidgetIntervalContainerMock(): MockObject&IWidgetIntervalContainer
    {
        return $this->createMock(IWidgetIntervalContainer::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getWidgetContextContainerMock(): MockObject&IWidgetContextContainer
    {
        return $this->createMock(IWidgetContextContainer::class);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    protected function getCharPatternMock(): MockObject&ICharPattern
    {
        return $this->createMock(ICharPattern::class);
    }

    protected function getStylePatternMock(): MockObject&IStylePattern
    {
        return $this->createMock(IStylePattern::class);
    }

    protected function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    protected function getWidgetRevolverBuilderMock(): MockObject&IWidgetRevolverBuilder
    {
        return $this->createMock(IWidgetRevolverBuilder::class);
    }

    protected function getCharFrameRevolverFactoryMock(): MockObject&ICharFrameRevolverFactory
    {
        return $this->createMock(ICharFrameRevolverFactory::class);
    }

    protected function getStyleFrameRevolverFactoryMock(): MockObject&IStyleFrameRevolverFactory
    {
        return $this->createMock(IStyleFrameRevolverFactory::class);
    }

    protected function getRevolverMock(): MockObject&IRevolver
    {
        return $this->createMock(IRevolver::class);
    }

    protected function getWidgetBuilderMock(): MockObject&IWidgetBuilder
    {
        return $this->createMock(IWidgetBuilder::class);
    }

    protected function getWidgetRevolverFactoryMock(): MockObject&IWidgetRevolverFactory
    {
        return $this->createMock(IWidgetRevolverFactory::class);
    }

    protected function getWidgetRevolverMock(): MockObject&IRevolver
    {
        return $this->createMock(IRevolver::class);
    }

    protected function getLoopProbeFactoryMock(): MockObject&ILoopProbeFactory
    {
        return $this->createMock(ILoopProbeFactory::class);
    }

    protected function getLoopSingletonFactoryMock(): MockObject&ILoopFactory
    {
        return $this->createMock(ILoopFactory::class);
    }

    protected function getLoopSetupBuilderMock(): MockObject&ILoopSetupBuilder
    {
        return $this->createMock(ILoopSetupBuilder::class);
    }

    protected function getLoopSetupStub(): Stub&ILoopSetup
    {
        return $this->createStub(ILoopSetup::class);
    }

    protected function getSettingsProviderMock(): MockObject&ISettingsProvider
    {
        return $this->createMock(ISettingsProvider::class);
    }

    protected function getSpinnerConfigMock(): MockObject&ISpinnerConfig
    {
        return $this->createMock(ISpinnerConfig::class);
    }

    protected function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    protected function getWidgetFactoryMock(): MockObject&IWidgetFactory
    {
        return $this->createMock(IWidgetFactory::class);
    }

    protected function getWidgetSettingsFactoryMock(): MockObject&IWidgetSettingsFactory
    {
        return $this->createMock(IWidgetSettingsFactory::class);
    }

    protected function getAuxSettingsMock(): MockObject&IAuxSettings
    {
        return $this->createMock(IAuxSettings::class);
    }

    protected function getIntervalNormalizerMock(): MockObject&IIntervalNormalizer
    {
        return $this->createMock(IIntervalNormalizer::class);
    }

    protected function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }

    protected function getCharFrameFactoryMock(): MockObject&ICharFrameFactory
    {
        return $this->createMock(ICharFrameFactory::class);
    }

    protected function getStyleFrameFactoryMock(): MockObject&IStyleFrameFactory
    {
        return $this->createMock(IStyleFrameFactory::class);
    }

    protected function getStyleRendererFactoryMock(): MockObject&IStyleRendererFactory
    {
        return $this->createMock(IStyleRendererFactory::class);
    }

    protected function getStyleRendererMock(): MockObject&IStyleRenderer
    {
        return $this->createMock(IStyleRenderer::class);
    }

    protected function getOutputBuilderMock(): MockObject&IBufferedOutputBuilder
    {
        return $this->createMock(IBufferedOutputBuilder::class);
    }

    protected function getTimerFactoryMock(): MockObject&ITimerFactory
    {
        return $this->createMock(ITimerFactory::class);
    }

    protected function getDriverOutputFactoryMock(): MockObject&IDriverOutputFactory
    {
        return $this->createMock(IDriverOutputFactory::class);
    }

    protected function getBufferedOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }

    protected function getCursorBuilderMock(): MockObject&IConsoleCursorBuilder
    {
        return $this->createMock(IConsoleCursorBuilder::class);
    }

    protected function getBufferedOutputFactoryMock(): MockObject&IBufferedOutputSingletonFactory
    {
        return $this->createMock(IBufferedOutputSingletonFactory::class);
    }

    protected function getCursorFactoryMock(): MockObject&IConsoleCursorFactory
    {
        return $this->createMock(IConsoleCursorFactory::class);
    }

    protected function getDriverOutputBuilderMock(): MockObject&IDriverOutputBuilder
    {
        return $this->createMock(IDriverOutputBuilder::class);
    }

    protected function getLoopProbeMock(): MockObject&ILoopProbe
    {
        return $this->createMock(ILoopProbe::class);
    }

    protected function getLoopSettingsFactoryMock(): MockObject&ILoopSettingsFactory
    {
        return $this->createMock(ILoopSettingsFactory::class);
    }

    protected function getTerminalSettingsFactoryMock(): MockObject&ITerminalSettingsFactory
    {
        return $this->createMock(ITerminalSettingsFactory::class);
    }

    protected function getAuxSettingsBuilderMock(): MockObject&IAuxSettingsBuilder
    {
        return $this->createMock(IAuxSettingsBuilder::class);
    }

    protected function getDriverSettingsMock(): MockObject&IDriverSettings
    {
        return $this->createMock(IDriverSettings::class);
    }

    protected function getLoopSetupFactoryMock(): MockObject&ILoopSetupFactory
    {
        return $this->createMock(ILoopSetupFactory::class);
    }

    protected function getDriverSettingsBuilderMock(): MockObject&IDriverSettingsBuilder
    {
        return $this->createMock(IDriverSettingsBuilder::class);
    }

    protected function getWidgetSettingsBuilderMock(): MockObject&IWidgetSettingsBuilder
    {
        return $this->createMock(IWidgetSettingsBuilder::class);
    }

    protected function getLoopSettingsMock(): MockObject&ILoopSettings
    {
        return $this->createMock(ILoopSettings::class);
    }

    protected function getTerminalSettingsMock(): MockObject&ITerminalSettings
    {
        return $this->createMock(ITerminalSettings::class);
    }

    protected function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    protected function getWidthMeasurerMock(): MockObject&IWidthMeasurer
    {
        return $this->createMock(IWidthMeasurer::class);
    }

    protected function getPatternStub(): Stub&IPattern
    {
        return $this->createStub(IPattern::class);
    }

    protected function getFrameStub(): Stub&IFrame
    {
        return $this->createStub(IFrame::class);
    }

    protected function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
    }

    protected function getCursorMock(): MockObject&IConsoleCursor
    {
        return $this->createMock(IConsoleCursor::class);
    }

    protected function getTimerMock(): MockObject&ITimer
    {
        return $this->createMock(ITimer::class);
    }

    protected function getSpinnerMock(): MockObject&ISpinner
    {
        return $this->createMock(ISpinner::class);
    }

    protected function getSpinnerStub(): Stub&ISpinner
    {
        return $this->createStub(ISpinner::class);
    }

    protected function getDriverOutputMock(): MockObject&IDriverOutput
    {
        return $this->createMock(IDriverOutput::class);
    }

    protected function getSpinnerStateStub(): Stub&ISpinnerState
    {
        return $this->createStub(ISpinnerState::class);
    }

    protected function getSpinnerStateMock(): MockObject&ISpinnerState
    {
        return $this->createMock(ISpinnerState::class);
    }

    protected function getResourceStreamMock(): MockObject&IResourceStream
    {
        return $this->createMock(IResourceStream::class);
    }

    protected function getBufferedOutputBuilderMock(): MockObject&IBufferedOutputBuilder
    {
        return $this->createMock(IBufferedOutputBuilder::class);
    }

    protected function getCursorStub(): Stub&IConsoleCursor
    {
        return $this->createStub(IConsoleCursor::class);
    }

    protected function getDriverOutputStub(): Stub&IDriverOutput
    {
        return $this->createStub(IDriverOutput::class);
    }

    protected function getTimerBuilderMock(): MockObject&ITimerBuilder
    {
        return $this->createMock(ITimerBuilder::class);
    }

    protected function getDriverBuilderMock(): MockObject&IDriverBuilder
    {
        return $this->createMock(IDriverBuilder::class);
    }

    protected function getTimerStub(): Stub&ITimer
    {
        return $this->createStub(ITimer::class);
    }

    protected function getDriverStub(): Stub&IDriver
    {
        return $this->createStub(IDriver::class);
    }

    protected function getDriverSetupMock(): MockObject&IDriverSetup
    {
        return $this->createMock(IDriverSetup::class);
    }

    protected function getIntegerNormalizerBuilderMock(): MockObject&IIntegerNormalizerBuilder
    {
        return $this->createMock(IIntegerNormalizerBuilder::class);
    }

    protected function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }

    protected function getWidgetContextMock(): MockObject&IWidgetContext
    {
        return $this->createMock(IWidgetContext::class);
    }

    protected function getStyleMock(): MockObject&IStyle
    {
        return $this->createMock(IStyle::class);
    }

    protected function getStyleFactoryMock(): MockObject&IStyleFactory
    {
        return $this->createMock(IStyleFactory::class);
    }

    protected function getStyleFrameRendererFactoryMock(): MockObject&IStyleFrameRendererFactory
    {
        return $this->createMock(IStyleFrameRendererFactory::class);
    }

    protected function getStyleFrameRendererMock(): MockObject&IStyleFrameRenderer
    {
        return $this->createMock(IStyleFrameRenderer::class);
    }

    protected function getCharFrameRendererMock(): MockObject&ICharFrameRenderer
    {
        return $this->createMock(ICharFrameRenderer::class);
    }

    protected function getStyleToAnsiStringConverterMock(): MockObject&IStyleToAnsiStringConverter
    {
        return $this->createMock(IStyleToAnsiStringConverter::class);
    }

    protected function getHexColorToAnsiCodeConverterMock(): MockObject&IHexColorToAnsiCodeConverter
    {
        return $this->createMock(IHexColorToAnsiCodeConverter::class);
    }

    protected function getAnsiColorParserMock(): MockObject&IAnsiColorParser
    {
        return $this->createMock(IAnsiColorParser::class);
    }

    protected function getStyleOptionsParserMock(): MockObject&IStyleOptionsParser
    {
        return $this->createMock(IStyleOptionsParser::class);
    }

    protected function getAnsiColorParserFactoryMock(): MockObject&IAnsiColorParserFactory
    {
        return $this->createMock(IAnsiColorParserFactory::class);
    }

    protected function getHexColorToAnsiCodeConverterFactoryMock(): MockObject&IHexColorToAnsiCodeConverterFactory
    {
        return $this->createMock(IHexColorToAnsiCodeConverterFactory::class);
    }

    protected function getFrameRevolverBuilderMock(): MockObject&IFrameRevolverBuilder
    {
        return $this->createMock(IFrameRevolverBuilder::class);
    }

    protected function getFrameCollectionFactoryMock(): MockObject&IFrameCollectionFactory
    {
        return $this->createMock(IFrameCollectionFactory::class);
    }

    protected function getFrameRevolverMock(): MockObject&IFrameRevolver
    {
        return $this->createMock(IFrameRevolver::class);
    }

    protected function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
    }

    protected function getOneElementFrameCollectionMock(): MockObject&IFrameCollection
    {
        $mockObject = $this->createMock(IFrameCollection::class);
        $mockObject->method('count')->willReturn(1);
        return $mockObject;
    }

    protected function getStyleFrameCollectionRendererMock(): MockObject&IStyleFrameCollectionRenderer
    {
        return $this->createMock(IStyleFrameCollectionRenderer::class);
    }

    protected function getCharFrameCollectionRendererMock(): MockObject&ICharFrameCollectionRenderer
    {
        return $this->createMock(ICharFrameCollectionRenderer::class);
    }

    protected function getStyleToAnsiStringConverterFactoryMock(): MockObject&IStyleToAnsiStringConverterFactory
    {
        return $this->createMock(IStyleToAnsiStringConverterFactory::class);
    }

    protected function getTerminalProbeMock(): MockObject&ITerminalProbe
    {
        return $this->createMock(ITerminalProbe::class);
    }

    protected function getSignalProcessingProbeMock(): MockObject&ISignalProcessingProbe
    {
        return $this->createMock(ISignalProcessingProbe::class);
    }
}
