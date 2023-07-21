<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(Settings::class, $settings);
    }

    public function getTesteeInstance(
        ?RunMethodOption $runMethodOption = null,
    ): ISettings {
        return
            new Settings(
                runMethodOption: $runMethodOption ?? RunMethodOption::AUTO,
            );
    }

    #[Test]
    public function canGetRunMethodOption(): void
    {
        $runMethodOption = RunMethodOption::ASYNC;

        $settings = $this->getTesteeInstance(
            runMethodOption: $runMethodOption,
        );

        self::assertEquals($runMethodOption, $settings->getRunMethodOption());
    }

    #[Test]
    public function canGetAuxSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(AuxSettings::class, $settings->getAuxSettings());

    }

    #[Test]
    public function canGetWidgetSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettings::class, $settings->getWidgetSettings());

    }

    #[Test]
    public function canGetRootWidgetSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettings::class, $settings->getRootWidgetSettings());

    }

    #[Test]
    public function canGetDriverSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSettings::class, $settings->getDriverSettings());

    }

    #[Test]
    public function canGetLoopSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSettings::class, $settings->getLoopSettings());

    }

    #[Test]
    public function canGetOutputSettings(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(OutputSettings::class, $settings->getOutputSettings());

    }

    #[Test]
    public function canSetRunMethodOption(): void
    {
        $runMethodOptionInitial = RunMethodOption::ASYNC;

        $settings = $this->getTesteeInstance(
            runMethodOption: $runMethodOptionInitial,
        );

        $runMethodOption = RunMethodOption::SYNCHRONOUS;

        self::assertNotEquals($runMethodOption, $settings->getRunMethodOption());

        $settings->setRunMethodOption($runMethodOption);

        self::assertEquals($runMethodOption, $settings->getRunMethodOption());
    }
}
