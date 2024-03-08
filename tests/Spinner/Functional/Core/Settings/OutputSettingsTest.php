<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\CursorOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\StylingOption;
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
        ?StylingOption $stylingOpion = null,
        ?CursorOption $cursorOption = null,
        ?InitializationOption $initializationOption = null,
        mixed $stream = null,
    ): IOutputSettings {
        return
            new OutputSettings(
                stylingOpion: $stylingOpion ?? StylingOption::AUTO,
                cursorOption: $cursorOption ?? CursorOption::AUTO,
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
    public function canGetStylingOption(): void
    {
        $stylingOpion = StylingOption::ANSI8;

        $settings = $this->getTesteeInstance(
            stylingOpion: $stylingOpion,
        );

        self::assertEquals($stylingOpion, $settings->getStylingOption());
    }

    #[Test]
    public function canGetCursorOption(): void
    {
        $cursorOption = CursorOption::VISIBLE;

        $settings = $this->getTesteeInstance(
            cursorOption: $cursorOption,
        );

        self::assertEquals($cursorOption, $settings->getCursorOption());
    }
}
