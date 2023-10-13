<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SpinnerSettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance(
            widgetSettings: null,
            autoAttach: false,
        );

        self::assertInstanceOf(SpinnerSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?IWidgetSettings $widgetSettings,
        ?bool $autoAttach,
    ): ISpinnerSettings {
        return
            new SpinnerSettings(
                widgetSettings: $widgetSettings,
                autoAttach: $autoAttach,
            );
    }

    #[Test]
    public function canGetWidgetSettings(): void
    {
        $widgetSettings = $this->getWidgetSettingsMock();

        $settings = $this->getTesteeInstance(
            widgetSettings: $widgetSettings,
            autoAttach: false,
        );

        self::assertSame($widgetSettings, $settings->getWidgetSettings());
    }

    protected function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    #[Test]
    public function canGetNullWidgetSettings(): void
    {
        $settings = $this->getTesteeInstance(
            widgetSettings: null,
            autoAttach: false,
        );

        self::assertNull($settings->getWidgetSettings());
    }

    #[Test]
    public function canGetAutoAttach(): void
    {
        $settings = $this->getTesteeInstance(
            widgetSettings: null,
            autoAttach: true,
        );

        self::assertTrue($settings->isAutoAttach());
    }
}
