<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner;

use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Loop\Contract\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ContainerModifyingTestCase;
use PHPUnit\Framework\Attributes\Test;

final class FacadeTest extends ContainerModifyingTestCase
{

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
    public function canGetLoop(): void
    {
        $loop = Facade::getLoop();

        self::assertInstanceOf(ALoopAdapter::class, $loop);
    }

    #[Test]
    public function loopObjectIsAlwaysSame(): void
    {
        $loop = Facade::getLoop();

        self::assertSame($loop, Facade::getLoop());
        self::assertSame($loop, Facade::getLoop());
        self::assertSame($loop, Facade::getLoop());
    }

    #[Test]
    public function settingsObjectIsAlwaysSame(): void
    {
        $settings = Facade::getSettings();

        self::assertSame($settings, Facade::getSettings());
        self::assertSame($settings, Facade::getSettings());
        self::assertSame($settings, Facade::getSettings());
    }

    #[Test]
    public function canGetDriver(): void
    {
        $driver = Facade::getDriver();

        self::assertInstanceOf(ADriver::class, $driver);
    }

    #[Test]
    public function canCreateSpinner(): void
    {
        $spinner = Facade::createSpinner();

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    #[Test]
    public function driverObjectIsAlwaysSame(): void
    {
        $driver = Facade::getDriver();

        self::assertSame($driver, Facade::getDriver());
        self::assertSame($driver, Facade::getDriver());
        self::assertSame($driver, Facade::getDriver());
    }
}
