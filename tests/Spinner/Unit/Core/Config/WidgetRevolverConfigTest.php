<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?IStylePalette $stylePalette = null,
        ?ICharPalette $charPalette = null,
        ?IRevolverConfig $revolverConfig = null,
    ): IWidgetRevolverConfig {
        return
            new WidgetRevolverConfig(
                stylePalette: $stylePalette ?? $this->getStylePaletteMock(),
                charPalette: $charPalette ?? $this->getCharPaletteMock(),
                revolverConfig: $revolverConfig ?? new RevolverConfig(),
            );
    }

    #[Test]
    public function canGetStylePalette(): void
    {
        $stylePalette = $this->getStylePaletteMock();

        $config = $this->getTesteeInstance(
            stylePalette: $stylePalette,
        );

        self::assertSame($stylePalette, $config->getStylePalette());
    }

    #[Test]
    public function canGetCharPalette(): void
    {
        $charPalette = $this->getCharPaletteMock();

        $config = $this->getTesteeInstance(
            charPalette: $charPalette,
        );

        self::assertSame($charPalette, $config->getCharPalette());
    }

    #[Test]
    public function canGetRevolverConfig(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(RevolverConfig::class, $config->getRevolverConfig());
    }

    #[Test]
    public function canGetRevolverConfigFromConstructor(): void
    {
        $revolverConfig = $this->getRevolverConfigMock();

        $config = $this->getTesteeInstance(
            revolverConfig: $revolverConfig,
        );

        self::assertSame($revolverConfig, $config->getRevolverConfig());
    }

    protected function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
    }
}
