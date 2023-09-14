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
        ?ISettings $settings = null,
    ): ISettingsProvider {
        return
            new SettingsProvider(
                settings: $settings ?? new Settings(),
            );
    }

    #[Test]
    public function canGetSettings(): void
    {
        $settings = new Settings();

        $provider = $this->getTesteeInstance(
            settings: $settings,
        );

        self::assertSame($settings, $provider->getSettings());
    }
}
