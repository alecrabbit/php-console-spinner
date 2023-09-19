<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IWidgetRevolverConfig $revolverConfig = null,
    ): IWidgetConfig {
        return
            new WidgetConfig(
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                revolverConfig: $revolverConfig ?? $this->getRevolverConfigMock(),
            );
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }

    #[Test]
    public function canGetLeadingSpacer(): void
    {
        $leadingSpacer = $this->getFrameMock();

        $config = $this->getTesteeInstance(
            leadingSpacer: $leadingSpacer,
        );

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
    }

    #[Test]
    public function canGetTrailingSpacer(): void
    {
        $trailingSpacer = $this->getFrameMock();

        $config = $this->getTesteeInstance(
            trailingSpacer: $trailingSpacer,
        );

        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
    }

    #[Test]
    public function canGetRevolverConfig(): void
    {
        $revolverConfig = $this->getRevolverConfigMock();

        $config = $this->getTesteeInstance(
            revolverConfig: $revolverConfig,
        );

        self::assertSame($revolverConfig, $config->getWidgetRevolverConfig());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $config = $this->getTesteeInstance();

        self::assertEquals(IWidgetConfig::class, $config->getIdentifier());
    }

    protected function getBakedPatternMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }
}
