<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SettingsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(Settings::class, $settings);
    }

    public function getTesteeInstance(): ISettings
    {
        return
            new Settings();
    }

    #[Test]
    public function canSetAndGetAuxSettings(): void
    {
        $settings = $this->getTesteeInstance();

        $auxSettings = new AuxSettings();

        $settings->set($auxSettings);

        self::assertSame($auxSettings, $settings->get(IAuxSettings::class));
    }

}
