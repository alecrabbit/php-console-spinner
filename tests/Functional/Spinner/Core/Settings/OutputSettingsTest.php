<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class OutputSettingsTest extends TestCase
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
        ?InitializationOption $initializationOption = null,
        mixed $stream = null,
    ): IOutputSettings {
        return
            new OutputSettings(
                stylingMethodOption: $stylingMethodOption ?? StylingMethodOption::AUTO,
                cursorVisibilityOption: $cursorVisibilityOption ?? CursorVisibilityOption::AUTO,
                initializationOption: $initializationOption ?? InitializationOption::AUTO,
                stream: $stream,
            );
    }

    #[Test]
    public function canGetInitializationOption(): void
    {
        $initializationOption = InitializationOption::ENABLED;

        $settings = $this->getTesteeInstance(
            initializationOption: $initializationOption,
        );

        self::assertEquals($initializationOption, $settings->getInitializationOption());
    }

    #[Test]
    public function canGetIdentifier(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertEquals(IOutputSettings::class, $settings->getIdentifier());
    }

    #[Test]
    public function canGetStream(): void
    {
        $stream = STDOUT;

        $settings = $this->getTesteeInstance(
            stream: $stream,
        );

        self::assertSame($stream, $settings->getStream());
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
    public function canGetCursorVisibilityOption(): void
    {
        $cursorVisibilityOption = CursorVisibilityOption::VISIBLE;

        $settings = $this->getTesteeInstance(
            cursorVisibilityOption: $cursorVisibilityOption,
        );

        self::assertEquals($cursorVisibilityOption, $settings->getCursorVisibilityOption());
    }
}
