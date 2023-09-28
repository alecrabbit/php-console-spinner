<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Pattern\Legacy\NoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\NoStylePattern;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyWidgetSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $leadingSpacer = new CharFrame('', 0);
        $trailingSpacer = new CharFrame('', 0);
        $stylePattern = new NoStylePattern();
        $charPattern = new NoCharPattern();

        $widgetSettings = $this->getTesteeInstance(
            $leadingSpacer,
            $trailingSpacer,
            $stylePattern,
            $charPattern
        );

        self::assertInstanceOf(LegacyWidgetSettings::class, $widgetSettings);
        self::assertSame($leadingSpacer, $widgetSettings->getLeadingSpacer());
        self::assertSame($trailingSpacer, $widgetSettings->getTrailingSpacer());
        self::assertSame($stylePattern, $widgetSettings->getStylePattern());
        self::assertSame($charPattern, $widgetSettings->getCharPattern());
    }

    public function getTesteeInstance(
        IFrame $leadingSpacer,
        IFrame $trailingSpacer,
        ILegacyPattern $stylePattern,
        ILegacyPattern $charPattern,
    ): ILegacyWidgetSettings {
        return new LegacyWidgetSettings(
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
            stylePattern: $stylePattern,
            charPattern: $charPattern,
        );
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $widgetSettings = $this->getTesteeInstance(
            new CharFrame('', 0),
            new CharFrame('', 0),
            new NoStylePattern(),
            new NoCharPattern()
        );

        $leadingSpacer = new CharFrame('', 0);
        $trailingSpacer = new CharFrame('', 0);
        $stylePattern = new NoStylePattern();
        $charPattern = new NoCharPattern();

        $widgetSettings->setLeadingSpacer($leadingSpacer);
        $widgetSettings->setTrailingSpacer($trailingSpacer);
        $widgetSettings->setStylePattern($stylePattern);
        $widgetSettings->setCharPattern($charPattern);

        self::assertInstanceOf(LegacyWidgetSettings::class, $widgetSettings);
        self::assertSame($leadingSpacer, $widgetSettings->getLeadingSpacer());
        self::assertSame($trailingSpacer, $widgetSettings->getTrailingSpacer());
        self::assertSame($stylePattern, $widgetSettings->getStylePattern());
        self::assertSame($charPattern, $widgetSettings->getCharPattern());
    }
}
