<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\A\ALegacySpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ICursorBuilder;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriver;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Contract\ISpinnerSetup;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

abstract class TestCaseWithPrebuiltMocksAndStubs extends TestCase
{
    protected function getWidgetConfigStub(): Stub&IWidgetConfig
    {
        return $this->createStub(IWidgetConfig::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getPatternMock(): MockObject&IPattern
    {
        return $this->createMock(IPattern::class);
    }

    protected function getConfigMock(): MockObject&IConfig
    {
        return $this->createMock(IConfig::class);
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

    protected function getRevolverMock(): MockObject&IRevolver
    {
        return $this->createMock(IRevolver::class);
    }

    protected function getConfigBuilderMock(): MockObject&IConfigBuilder
    {
        return $this->createMock(IConfigBuilder::class);
    }

    protected function getSpinnerBuilderMock(): MockObject&ILegacySpinnerBuilder
    {
        return $this->createMock(ILegacySpinnerBuilder::class);
    }

    protected function getLoopInitializerMock(): MockObject&ILoopSetup
    {
        return $this->createMock(ILoopSetup::class);
    }

    protected function getSpinnerSetupMock(): MockObject&ISpinnerSetup
    {
        return $this->createMock(ISpinnerSetup::class);
    }

    protected function getDriverBuilderMock(): MockObject&ILegacyDriverBuilder
    {
        return $this->createMock(ILegacyDriverBuilder::class);
    }

    protected function getWidgetBuilderMock(): MockObject&IWidgetBuilder
    {
        return $this->createMock(IWidgetBuilder::class);
    }

    protected function getLegacySpinnerMock(): MockObject&ALegacySpinner
    {
        return $this->createMock(ALegacySpinner::class);
    }

    protected function getLoopProbeFactoryMock(): MockObject&ILoopProbeFactory
    {
        return $this->createMock(ILoopProbeFactory::class);
    }

    protected function getLoopSetupBuilderMock(): MockObject&ILoopSetupBuilder
    {
        return $this->createMock(ILoopSetupBuilder::class);
    }

    protected function getDefaultsProviderMock(): MockObject&IDefaultsProvider
    {
        return $this->createMock(IDefaultsProvider::class);
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

    protected function getFrameFactoryMock(): MockObject&IFrameFactory
    {
        return $this->createMock(IFrameFactory::class);
    }

    protected function getFrameRevolverBuilderMock(): MockObject&IFrameRevolverBuilder
    {
        return $this->createMock(IFrameRevolverBuilder::class);
    }

    protected function getOutputBuilderMock(): MockObject&IBufferedOutputBuilder
    {
        return $this->createMock(IBufferedOutputBuilder::class);
    }

    protected function getTimerFactoryMock(): MockObject&ITimerBuilder
    {
        return $this->createMock(ITimerBuilder::class);
    }

    protected function getBufferedOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }

    protected function getCursorBuilderMock(): MockObject&ICursorBuilder
    {
        return $this->createMock(ICursorBuilder::class);
    }

    protected function getBufferedOutputFactoryMock(): MockObject&IBufferedOutputSingletonFactory
    {
        return $this->createMock(IBufferedOutputSingletonFactory::class);
    }

    protected function getAuxConfigMock(): MockObject&IAuxConfig
    {
        return $this->createMock(IAuxConfig::class);
    }

    protected function getSpinnerAttacherMock(): MockObject&ISpinnerAttacher
    {
        return $this->createMock(ISpinnerAttacher::class);
    }

    protected function getLoopProbeMock(): MockObject&ILoopProbe
    {
        return $this->createMock(ILoopProbe::class);
    }

    protected function getLoopSettingsBuilderMock(): MockObject&ILoopSettingsBuilder
    {
        return $this->createMock(ILoopSettingsBuilder::class);
    }

    protected function getSpinnerSettingsBuilderMock(): MockObject&ISpinnerSettingsBuilder
    {
        return $this->createMock(ISpinnerSettingsBuilder::class);
    }

    protected function getAuxSettingsBuilderMock(): MockObject&IAuxSettingsBuilder
    {
        return $this->createMock(IAuxSettingsBuilder::class);
    }

    protected function getDriverSettingsMock(): MockObject&IDriverSettings
    {
        return $this->createMock(IDriverSettings::class);
    }

    protected function getDriverSettingsBuilderMock(): MockObject&IDriverSettingsBuilder
    {
        return $this->createMock(IDriverSettingsBuilder::class);
    }

    protected function getWidgetSettingsBuilderMock(): MockObject&IWidgetSettingsBuilder
    {
        return $this->createMock(IWidgetSettingsBuilder::class);
    }

    protected function getSpinnerSettingsMock(): MockObject&ISpinnerSettings
    {
        return $this->getMockForAbstractClass(ISpinnerSettings::class);
    }

    protected function getLoopSettingsMock(): MockObject&ILoopSettings
    {
        return $this->getMockForAbstractClass(ILoopSettings::class);
    }

    protected function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    protected function getWidthMeasurerMock(): MockObject&IWidthMeasurer
    {
        return $this->createMock(IWidthMeasurer::class);
    }

    protected function getLoopConfigStub(): Stub&ILoopConfig
    {
        return $this->createStub(ILoopConfig::class);
    }

    protected function getPatternStub(): Stub&IPattern
    {
        return $this->createStub(IPattern::class);
    }

    protected function getFrameStub(): Stub&IFrame
    {
        return $this->createStub(IFrame::class);
    }

    protected function getDriverMock(): MockObject&ILegacyDriver
    {
        return $this->createMock(ILegacyDriver::class);
    }

    protected function getWidgetCompositeMock(): MockObject&IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
    }

    protected function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
    }

    protected function getCursorMock(): MockObject&ICursor
    {
        return $this->createMock(ICursor::class);
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

    protected function getCursorStub(): Stub&ICursor
    {
        return $this->createStub(ICursor::class);
    }
}
