<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class OutputSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(OutputSettings::class, $settings);
    }

    public function getTesteeInstance(
        ?StylingMethodOption $stylingMethodOption = null,
        ?CursorVisibilityOption $cursorVisibilityOption = null,
    ): IOutputSettings {
        return
            new OutputSettings(
                stylingMethodOption: $stylingMethodOption ?? StylingMethodOption::AUTO,
                cursorVisibilityOption: $cursorVisibilityOption ?? CursorVisibilityOption::AUTO,
            );
    }

    #[Test]
    public function canGetStylingMethodOption(): void
    {
        $stylingMethodOption = StylingMethodOption::ANSI8;

        $settings = $this->getTesteeInstance(
            stylingMethodOption: $stylingMethodOption,
        );

        self::assertEquals($stylingMethodOption, $settings->getStylingMethodOption());
    }

    #[Test]
    public function canSetStylingMethodOption(): void
    {
        $stylingMethodOptionInitial = StylingMethodOption::ANSI4;

        $settings = $this->getTesteeInstance(
            stylingMethodOption: $stylingMethodOptionInitial,
        );

        $stylingMethodOption = StylingMethodOption::ANSI24;

        self::assertNotEquals($stylingMethodOption, $settings->getStylingMethodOption());

        $settings->setStylingMethodOption($stylingMethodOption);

        self::assertEquals($stylingMethodOption, $settings->getStylingMethodOption());
    }

    #[Test]
    public function canGetCursorVisibilityOption(): void
    {
        $cursorVisibilityOption = CursorVisibilityOption::VISIBLE;

        $settings = $this->getTesteeInstance(
            cursorVisibilityOption: $cursorVisibilityOption,
        );

        self::assertEquals($cursorVisibilityOption, $settings->getCursorVisibilityOption());
    }

    #[Test]
    public function canSetCursorVisibilityOption(): void
    {
        $cursorVisibilityOptionInitial = CursorVisibilityOption::HIDDEN;

        $settings = $this->getTesteeInstance(
            cursorVisibilityOption: $cursorVisibilityOptionInitial,
        );

        $cursorVisibilityOption = CursorVisibilityOption::VISIBLE;

        self::assertNotEquals($cursorVisibilityOption, $settings->getCursorVisibilityOption());

        $settings->setCursorVisibilityOption($cursorVisibilityOption);

        self::assertEquals($cursorVisibilityOption, $settings->getCursorVisibilityOption());
    }
}
