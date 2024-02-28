<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
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
        ?ISequenceFrame $leadingSpacer = null,
        ?ISequenceFrame $trailingSpacer = null,
        ?IStylePalette $stylePalette = null,
        ?ICharPalette $charPalette = null,
    ): IRootWidgetSettings {
        return
            new RootWidgetSettings(
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                stylePalette: $stylePalette ?? $this->getStylePaletteMock(),
                charPalette: $charPalette ?? $this->getCharPaletteMock(),
            );
    }

    protected function getFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
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
        $stylePalette = $this->getStylePaletteMock();

        $settings = $this->getTesteeInstance(
            stylePalette: $stylePalette,
        );

        self::assertSame($stylePalette, $settings->getStylePalette());
    }

    #[Test]
    public function canGetCharPalette(): void
    {
        $charPalette = $this->getCharPaletteMock();

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
        $stylePalette = $this->getStylePaletteMock();
        $charPalette = $this->getCharPaletteMock();

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
