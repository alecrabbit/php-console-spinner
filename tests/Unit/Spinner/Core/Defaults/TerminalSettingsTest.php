<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyTerminalSettings;
use AlecRabbit\Spinner\Core\Settings\LegacyTerminalSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class TerminalSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $terminalSettings = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyTerminalSettings::class, $terminalSettings);
    }

    public function getTesteeInstance(
        ?CursorVisibilityOption $optionCursor = null,
        ?StylingMethodOption $optionStyleMode = null,
        $outputStream = null,
    ): ILegacyTerminalSettings {
        return new LegacyTerminalSettings(
            optionCursor: $optionCursor ?? CursorVisibilityOption::VISIBLE,
            optionStyleMode: $optionStyleMode ?? StylingMethodOption::NONE,
            outputStream: $outputStream ?? STDERR,
        );
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $optionCursor = CursorVisibilityOption::VISIBLE;
        $optionStyleMode = StylingMethodOption::NONE;
        $resource = fopen('php://memory', 'rb+');

        $terminalSettings = $this->getTesteeInstance(
            optionCursor: $optionCursor,
            optionStyleMode: $optionStyleMode,
            outputStream: $resource,
        );
        self::assertInstanceOf(LegacyTerminalSettings::class, $terminalSettings);
        self::assertSame($optionCursor, $terminalSettings->getOptionCursor());
        self::assertSame($optionStyleMode, $terminalSettings->getOptionStyleMode());
        self::assertSame($resource, $terminalSettings->getOutputStream());

        $optionCursor = CursorVisibilityOption::HIDDEN;
        $optionStyleMode = StylingMethodOption::ANSI8;
        $resource = fopen('php://memory', 'rb+');

        $terminalSettings->setOptionCursor($optionCursor);
        $terminalSettings->setOptionStyleMode($optionStyleMode);
        $terminalSettings->setOutputStream($resource);

        self::assertSame($optionCursor, $terminalSettings->getOptionCursor());
        self::assertSame($optionStyleMode, $terminalSettings->getOptionStyleMode());
        self::assertSame($resource, $terminalSettings->getOutputStream());
    }
}
