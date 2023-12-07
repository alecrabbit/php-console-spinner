<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\WidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $stylePalette = $this->getStylePaletteMock();
        $charPalette = $this->getCharPaletteMock();
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

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
    }

    protected function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    protected function getWidgetRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }
}
