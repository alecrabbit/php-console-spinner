<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RootWidgetSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(RootWidgetSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IPalette $stylePalette = null,
        ?IPalette $charPalette = null,
    ): IRootWidgetSettings {
        return
            new RootWidgetSettings(
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                stylePalette: $stylePalette ?? $this->getPaletteMock(),
                charPalette: $charPalette ?? $this->getPaletteMock(),
            );
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    #[Test]
    public function canGetLeadingSpacer(): void
    {
        $leadingSpacer = $this->getFrameMock();

        $settings = $this->getTesteeInstance(
            leadingSpacer: $leadingSpacer,
        );

        self::assertSame($leadingSpacer, $settings->getLeadingSpacer());
    }

    #[Test]
    public function canGetTrailingSpacer(): void
    {
        $trailingSpacer = $this->getFrameMock();

        $settings = $this->getTesteeInstance(
            trailingSpacer: $trailingSpacer,
        );

        self::assertSame($trailingSpacer, $settings->getTrailingSpacer());
    }

    #[Test]
    public function canGetStylePalette(): void
    {
        $stylePalette = $this->getPaletteMock();

        $settings = $this->getTesteeInstance(
            stylePalette: $stylePalette,
        );

        self::assertSame($stylePalette, $settings->getStylePalette());
    }

    #[Test]
    public function canGetCharPalette(): void
    {
        $charPalette = $this->getPaletteMock();

        $settings = $this->getTesteeInstance(
            charPalette: $charPalette,
        );

        self::assertSame($charPalette, $settings->getCharPalette());
    }

    #[Test]
    public function canBeInstantiatedWithAllValues(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePalette = $this->getPaletteMock();
        $charPalette = $this->getPaletteMock();

        $settings = $this->getTesteeInstance(
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
            stylePalette: $stylePalette,
            charPalette: $charPalette,
        );

        self::assertSame($leadingSpacer, $settings->getLeadingSpacer());
        self::assertSame($trailingSpacer, $settings->getTrailingSpacer());
        self::assertSame($stylePalette, $settings->getStylePalette());
        self::assertSame($charPalette, $settings->getCharPalette());
    }
}
