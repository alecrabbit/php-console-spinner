<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\WidgetSettings;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\NoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\NoStylePattern;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $leadingSpacer = new Frame('', 0);
        $trailingSpacer = new Frame('', 0);
        $stylePattern = new NoStylePattern();
        $charPattern = new NoCharPattern();

        $widgetSettings = $this->getTesteeInstance(
            $leadingSpacer,
            $trailingSpacer,
            $stylePattern,
            $charPattern
        );

        self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
        self::assertSame($leadingSpacer, $widgetSettings->getLeadingSpacer());
        self::assertSame($trailingSpacer, $widgetSettings->getTrailingSpacer());
        self::assertSame($stylePattern, $widgetSettings->getStylePattern());
        self::assertSame($charPattern, $widgetSettings->getCharPattern());
    }

    public function getTesteeInstance(
        IFrame $leadingSpacer,
        IFrame $trailingSpacer,
        IPattern $stylePattern,
        IPattern $charPattern,
    ): IWidgetSettings {
        return
            new WidgetSettings(
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
            new Frame('', 0),
            new Frame('', 0),
            new NoStylePattern(),
            new NoCharPattern()
        );

        $leadingSpacer = new Frame('', 0);
        $trailingSpacer = new Frame('', 0);
        $stylePattern = new NoStylePattern();
        $charPattern = new NoCharPattern();

        $widgetSettings->setLeadingSpacer($leadingSpacer);
        $widgetSettings->setTrailingSpacer($trailingSpacer);
        $widgetSettings->setStylePattern($stylePattern);
        $widgetSettings->setCharPattern($charPattern);

        self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
        self::assertSame($leadingSpacer, $widgetSettings->getLeadingSpacer());
        self::assertSame($trailingSpacer, $widgetSettings->getTrailingSpacer());
        self::assertSame($stylePattern, $widgetSettings->getStylePattern());
        self::assertSame($charPattern, $widgetSettings->getCharPattern());
    }
}
