<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Factory\LoopFactoryTest;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config\ConfigBuilderTest;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\IntervalFactoryTest;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\SpinnerFactoryTest;
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

    protected function getConfigMock(): IConfig&MockObject
    {
        return $this->createMock(IConfig::class);
    }

    protected function getPatternMock(): IPattern&MockObject
    {
        return $this->createMock(IPattern::class);
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
}
