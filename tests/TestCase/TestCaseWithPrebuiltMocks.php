<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IBufferedOutput;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\ICursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\ICursorBuilder;
use AlecRabbit\Spinner\Core\IOutputBuilder;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use PHPUnit\Framework\MockObject\MockObject;

abstract class TestCaseWithPrebuiltMocks extends TestCase
{
    protected function getWidgetConfigMock(): WidgetConfig
    {
        return
            new WidgetConfig(
                $this->getFrameMock(),
                $this->getFrameMock(),
                $this->getPatternMock(),
                $this->getPatternMock()
            );
    }

    protected function getFrameMock(): IFrame&MockObject
    {
        return $this->createMock(IFrame::class);
    }

    protected function getPatternMock(): IPattern&MockObject
    {
        return $this->createMock(IPattern::class);
    }

    protected function getConfigMock(): IConfig&MockObject
    {
        return $this->createMock(IConfig::class);
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    protected function getRevolverFactoryMock(): IRevolverFactory&MockObject
    {
        return $this->createMock(IRevolverFactory::class);
    }

    protected function getWidgetRevolverBuilderMock(): IWidgetRevolverBuilder&MockObject
    {
        return $this->createMock(IWidgetRevolverBuilder::class);
    }

    protected function getRevolverMock(): IRevolver&MockObject
    {
        return $this->createMock(IRevolver::class);
    }

    protected function getConfigBuilderMock(): IConfigBuilder&MockObject
    {
        return $this->createMock(IConfigBuilder::class);
    }

    protected function getSpinnerBuilderMock(): ISpinnerBuilder&MockObject
    {
        return $this->createMock(ISpinnerBuilder::class);
    }

    protected function getDriverBuilderMock(): IDriverBuilder&MockObject
    {
        return $this->createMock(IDriverBuilder::class);
    }

    protected function getWidgetBuilderMock(): IWidgetBuilder&MockObject
    {
        return $this->createMock(IWidgetBuilder::class);
    }

    protected function getSpinnerMock(): ASpinner&MockObject
    {
        return $this->createMock(ASpinner::class);
    }

    protected function getLoopProbeFactoryMock(): MockObject&ILoopProbeFactory
    {
        return $this->createMock(ILoopProbeFactory::class);
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

    protected function getOutputBuilderMock(): MockObject&IOutputBuilder
    {
        return $this->createMock(IOutputBuilder::class);
    }

    protected function getTimerFactoryMock(): MockObject&ITimerFactory
    {
        return $this->createMock(ITimerFactory::class);
    }

    protected function getBufferedOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }

    protected function getCursorBuilderMock(): MockObject&ICursorBuilder
    {
        return $this->createMock(ICursorBuilder::class);
    }

    protected function getAuxConfigMock(): MockObject&IAuxConfig
    {
        return $this->createMock(IAuxConfig::class);
    }
}
