<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
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
}
