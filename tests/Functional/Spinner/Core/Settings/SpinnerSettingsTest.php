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
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?IWidgetSettings $widgetSettings = null,
        ?bool $autoAttach = null,
    ): ISpinnerSettings {
        return
            new SpinnerSettings(
                widgetSettings: $widgetSettings ?? $this->getWidgetSettingsMock(),
                autoAttach: $autoAttach ?? false,
            );
    }

    protected function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    #[Test]
    public function canGetWidgetSettings(): void
    {
        $widgetSettings = $this->getWidgetSettingsMock();

        $settings = $this->getTesteeInstance(
            widgetSettings: $widgetSettings,
        );

        self::assertSame($widgetSettings, $settings->getWidgetSettings());
    }

    #[Test]
    public function canGetAutoAttach(): void
    {
        $settings = $this->getTesteeInstance(
            autoAttach: true,
        );

        self::assertTrue($settings->isAutoAttach());
    }
}
