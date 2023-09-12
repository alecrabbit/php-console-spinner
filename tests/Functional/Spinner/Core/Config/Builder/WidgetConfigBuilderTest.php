<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Builder\WidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $revolverConfig = $this->getRevolverConfigMock();

        $config = $configBuilder
            ->withLeadingSpacer($leadingSpacer)
            ->withTrailingSpacer($trailingSpacer)
            ->withRevolverConfig($revolverConfig)
            ->build()
        ;

        self::assertInstanceOf(WidgetConfig::class, $config);

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($revolverConfig, $config->getRevolverConfig());
    }

    protected function getTesteeInstance(): IWidgetConfigBuilder
    {
        return
            new WidgetConfigBuilder();
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }
}
