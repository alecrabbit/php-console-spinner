<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
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
