<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\SettingsProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

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
                userSettings: $userSettings ?? new Settings(),
                defaultSettings: $defaultSettings ?? new Settings(),
                detectedSettings: $detectedSettings ?? new Settings(),
            );
    }

    #[Test]
    public function canGetUserSettings(): void
    {
        $settings = new Settings();

        $provider = $this->getTesteeInstance(
            userSettings: $settings,
        );

        self::assertSame($settings, $provider->getUserSettings());
    }

    #[Test]
    public function canGetDefaultSettings(): void
    {
        $settings = new Settings();

        $provider = $this->getTesteeInstance(
            defaultSettings: $settings,
        );

        self::assertSame($settings, $provider->getDefaultSettings());
    }

    #[Test]
    public function canGetDetectedSettings(): void
    {
        $settings = new Settings();

        $provider = $this->getTesteeInstance(
            detectedSettings: $settings,
        );

        self::assertSame($settings, $provider->getDetectedSettings());
    }
}
