<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
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
}
