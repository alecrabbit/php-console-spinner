<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\SettingsProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SettingsProviderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $provider = $this->getTesteeInstance();

        self::assertInstanceOf(SettingsProvider::class, $provider);
    }

    public function getTesteeInstance(
        ?ISettings $userSettings = null,
        ?ISettings $defaultSettings = null,
        ?ISettings $detectedSettings = null,
    ): ISettingsProvider {
        return
            new SettingsProvider(
                userSettings: $userSettings ?? $this->getSettingsMock(),
                defaultSettings: $defaultSettings ?? $this->getSettingsMock(),
                detectedSettings: $detectedSettings ?? $this->getSettingsMock(),
            );
    }

    private function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }

    #[Test]
    public function canGetSettings(): void
    {
        $settings = $this->getSettingsMock();

        $provider = $this->getTesteeInstance(
            userSettings: $settings,
        );

        self::assertSame($settings, $provider->getUserSettings());
    }

    #[Test]
    public function canGetDefaultSettings(): void
    {
        $settings = $this->getSettingsMock();

        $provider = $this->getTesteeInstance(
            defaultSettings: $settings,
        );

        self::assertSame($settings, $provider->getDefaultSettings());
    }

    #[Test]
    public function canGetDetectedSettings(): void
    {
        $settings = $this->getSettingsMock();

        $provider = $this->getTesteeInstance(
            detectedSettings: $settings,
        );

        self::assertSame($settings, $provider->getDetectedSettings());
    }
}
