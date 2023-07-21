<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class FacadeTest extends TestCase
{
    private ?ISettings $settings = null;

//    #[Test]
//    public function canNotBeInstantiated(): void
//    {
//        $this->expectException(\Error::class);
//        $this->expectExceptionMessage('Call to private AlecRabbit\Spinner\Facade::__construct()');
//        $facade = new Facade();
//    }

    #[Test]
    public function canGetSettings(): void
    {
        $settings = Facade::getSettings();

        self::assertInstanceOf(Settings::class, $settings);
    }

    #[Test]
    public function settingsObjectIsAlwaysSame(): void
    {
        $settings = Facade::getSettings();

        self::assertInstanceOf(Settings::class, $settings);

        self::assertSame($settings, Facade::getSettings());
        self::assertSame($settings, Facade::getSettings());
        self::assertSame($settings, Facade::getSettings());
    }

    protected function setUp(): void
    {
        $this->settings = self::getPropertyValue('settings', Facade::class);
        self::setPropertyValue(Facade::class, 'settings', null);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Facade::class, 'settings', $this->settings);
    }
}
