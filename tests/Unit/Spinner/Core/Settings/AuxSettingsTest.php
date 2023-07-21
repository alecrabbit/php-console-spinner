<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class AuxSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(AuxSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?RunMethodOption $runMethodOption = null,
    ): IAuxSettings {
        return
            new AuxSettings(
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
