<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ILegacyLoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ISignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ILegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Contract\IWeakMap;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyTerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\Legacy\ILegacyWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\ICharLegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalLegacyProbe;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

/**
 * @deprecated Use `TestCase` instead and implement required mock methods by your tests.
 */
abstract class TestCaseWithPrebuiltMocksAndStubs extends TestCase
{
    protected function getWeakMapMock(): MockObject&IWeakMap
    {
        return $this->createMock(IWeakMap::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getWidgetCompositeChildrenContainerMock(): MockObject&IWidgetCompositeChildrenContainer
    {
        return $this->createMock(IWidgetCompositeChildrenContainer::class);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    protected function getWidgetCompositeMock(): MockObject&IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    protected function getCharPatternMock(): MockObject&ICharLegacyPattern
    {
        return $this->createMock(ICharLegacyPattern::class);
    }

    protected function getStylePatternMock(): MockObject&IStyleLegacyPattern
    {
        return $this->createMock(IStyleLegacyPattern::class);
    }

    protected function getLegacyWidgetSettingsMock(): MockObject&ILegacyWidgetSettings
    {
        return $this->createMock(ILegacyWidgetSettings::class);
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

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    protected function getLoopProbeFactoryMock(): MockObject&ILegacyLoopProbeFactory
    {
        return $this->createMock(ILegacyLoopProbeFactory::class);
    }

    protected function getLoopSingletonFactoryMock(): MockObject&ILoopFactory
    {
        return $this->createMock(ILoopFactory::class);
    }

    protected function getLoopAutoStarterBuilderMock(): MockObject&ILegacyLoopAutoStarterBuilder
    {
        return $this->createMock(ILegacyLoopAutoStarterBuilder::class);
    }

    protected function getSignalHandlersSetupBuilderMock(): MockObject&ISignalHandlersSetupBuilder
    {
        return $this->createMock(ISignalHandlersSetupBuilder::class);
    }

    protected function getLoopAutoStarterFactoryMock(): MockObject&ILegacyLoopAutoStarterFactory
    {
        return $this->createMock(ILegacyLoopAutoStarterFactory::class);
    }

    protected function getSignalHandlersSetupStub(): Stub&ILegacySignalHandlersSetup
    {
        return $this->createStub(ILegacySignalHandlersSetup::class);
    }

    protected function getLoopAutoStarterStub(): Stub&ILegacyLoopAutoStarter
    {
        return $this->createStub(ILegacyLoopAutoStarter::class);
    }

    protected function getLegacySettingsProviderMock(): MockObject&ILegacySettingsProvider
    {
        return $this->createMock(ILegacySettingsProvider::class);
    }

    protected function getSpinnerConfigMock(): MockObject&ILegacySpinnerConfig
    {
        return $this->createMock(ILegacySpinnerConfig::class);
    }

    protected function getLegacyWidgetConfigMock(): MockObject&ILegacyWidgetConfig
    {
        return $this->createMock(ILegacyWidgetConfig::class);
    }

    protected function getWidgetCompositeFactoryMock(): MockObject&IWidgetCompositeFactory
    {
        return $this->createMock(IWidgetCompositeFactory::class);
    }

    protected function getWidgetSettingsFactoryMock(): MockObject&ILegacyWidgetSettingsFactory
    {
        return $this->createMock(ILegacyWidgetSettingsFactory::class);
    }

    protected function getLegacyAuxSettingsMock(): MockObject&ILegacyAuxSettings
    {
        return $this->createMock(ILegacyAuxSettings::class);
    }

    protected function getIntervalNormalizerMock(): MockObject&IIntervalNormalizer
    {
        return $this->createMock(IIntervalNormalizer::class);
    }

    protected function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
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

    protected function getTerminalSettingsFactoryMock(): MockObject&ILegacyTerminalSettingsFactory
    {
        return $this->createMock(ILegacyTerminalSettingsFactory::class);
    }

    protected function getLegacyAuxSettingsBuilderMock(): MockObject&ILegacyAuxSettingsBuilder
    {
        return $this->createMock(ILegacyAuxSettingsBuilder::class);
    }

    protected function getLegacyDriverSettingsMock(): MockObject&ILegacyDriverSettings
    {
        return $this->createMock(ILegacyDriverSettings::class);
    }

    protected function getLegacyWidgetSettingsBuilderMock(): MockObject&ILegacyWidgetSettingsBuilder
    {
        return $this->createMock(ILegacyWidgetSettingsBuilder::class);
    }

    protected function getLegacyLoopSettingsMock(): MockObject&ILegacyLoopSettings
    {
        return $this->createMock(ILegacyLoopSettings::class);
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

    protected function getCursorMock(): MockObject&IConsoleCursor
    {
        return $this->createMock(IConsoleCursor::class);
    }

    protected function getTimerMock(): MockObject&ITimer
    {
        return $this->createMock(ITimer::class);
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

    protected function getTerminalProbeMock(): MockObject&ITerminalLegacyProbe
    {
        return $this->createMock(ITerminalLegacyProbe::class);
    }

    protected function getSignalProcessingProbeMock(): MockObject&ILegacySignalProcessingLegacyProbe
    {
        return $this->createMock(ILegacySignalProcessingLegacyProbe::class);
    }
}
