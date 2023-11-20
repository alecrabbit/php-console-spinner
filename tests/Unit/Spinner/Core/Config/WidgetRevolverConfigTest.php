<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
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
        ?IPalette $stylePalette = null,
        ?IPalette $charPalette = null,
        ?IRevolverConfig $revolverConfig = null,
    ): IWidgetRevolverConfig {
        if ($revolverConfig === null) {
            return new WidgetRevolverConfig(
                stylePalette: $stylePalette ?? $this->getPaletteMock(),
                charPalette: $charPalette ?? $this->getPaletteMock(),
                revolverConfig: new RevolverConfig(),
            );
        }

        return
            new WidgetRevolverConfig(
                stylePalette: $stylePalette ?? $this->getPaletteMock(),
                charPalette: $charPalette ?? $this->getPaletteMock(),
                revolverConfig: $revolverConfig,
            );
    }

    protected function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    #[Test]
    public function canGetStylePalette(): void
    {
        $stylePalette = $this->getPaletteMock();

        $config = $this->getTesteeInstance(
            stylePalette: $stylePalette,
        );

        self::assertSame($stylePalette, $config->getStylePalette());
    }

    #[Test]
    public function canGetCharPalette(): void
    {
        $charPalette = $this->getPaletteMock();

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
}
