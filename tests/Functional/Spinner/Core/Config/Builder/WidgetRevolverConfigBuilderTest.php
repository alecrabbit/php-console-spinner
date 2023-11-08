<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\WidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $stylePalette = $this->getPaletteMock();
        $charPalette = $this->getPaletteMock();
        $revolverConfig = $this->getRevolverConfigMock();

        $config = $configBuilder
            ->withStylePalette($stylePalette)
            ->withCharPalette($charPalette)
            ->withRevolverConfig($revolverConfig)
            ->build()
        ;

        self::assertInstanceOf(WidgetRevolverConfig::class, $config);

        self::assertSame($stylePalette, $config->getStylePalette());
        self::assertSame($charPalette, $config->getCharPalette());
        self::assertSame($revolverConfig, $config->getRevolverConfig());
    }

    protected function getTesteeInstance(): IWidgetRevolverConfigBuilder
    {
        return
            new WidgetRevolverConfigBuilder();
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    protected function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    protected function getWidgetRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }
}
