<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
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
    ): IWidgetRevolverConfig {
        return
            new WidgetRevolverConfig(
                stylePalette: $stylePalette ?? $this->getPaletteMock(),
                charPalette: $charPalette ?? $this->getPaletteMock(),
            );
    }

    protected function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    #[Test]
    public function canStylePalette(): void
    {
        $stylePalette = $this->getPaletteMock();

        $config = $this->getTesteeInstance(
            stylePalette: $stylePalette,
        );

        self::assertSame($stylePalette, $config->getStylePalette());
    }

    #[Test]
    public function canCharPalette(): void
    {
        $charPalette = $this->getPaletteMock();

        $config = $this->getTesteeInstance(
            charPalette: $charPalette,
        );

        self::assertSame($charPalette, $config->getCharPalette());
    }

    protected function getRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }
}
