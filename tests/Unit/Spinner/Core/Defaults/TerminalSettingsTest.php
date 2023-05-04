<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Settings\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Settings\TerminalSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class TerminalSettingsTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $terminalSettings = $this->getTesteeInstance();

        self::assertInstanceOf(TerminalSettings::class, $terminalSettings);
    }

    public function getTesteeInstance(
        ?OptionCursor $optionCursor = null,
        ?OptionStyleMode $optionStyleMode = null,
        $outputStream = null,
    ): ITerminalSettings {
        return new TerminalSettings(
            optionCursor: $optionCursor ?? OptionCursor::VISIBLE,
            optionStyleMode: $optionStyleMode ?? OptionStyleMode::NONE,
            outputStream: $outputStream ?? STDERR,
        );
    }

    #[Test]
    public function valuesCanBeOverriddenWithSetters(): void
    {
        $optionCursor = OptionCursor::VISIBLE;
        $optionStyleMode = OptionStyleMode::NONE;
        $resource = fopen('php://memory', 'rb+');

        $terminalSettings = $this->getTesteeInstance(
            optionCursor: $optionCursor,
            optionStyleMode: $optionStyleMode,
            outputStream: $resource,
        );
        self::assertInstanceOf(TerminalSettings::class, $terminalSettings);
        self::assertSame($optionCursor, $terminalSettings->getOptionCursor());
        self::assertSame($optionStyleMode, $terminalSettings->getOptionStyleMode());
        self::assertSame($resource, $terminalSettings->getOutputStream());

        $optionCursor = OptionCursor::HIDDEN;
        $optionStyleMode = OptionStyleMode::ANSI8;
        $resource = fopen('php://memory', 'rb+');

        $terminalSettings->setOptionCursor($optionCursor);
        $terminalSettings->setOptionStyleMode($optionStyleMode);
        $terminalSettings->setOutputStream($resource);

        self::assertSame($optionCursor, $terminalSettings->getOptionCursor());
        self::assertSame($optionStyleMode, $terminalSettings->getOptionStyleMode());
        self::assertSame($resource, $terminalSettings->getOutputStream());
    }
}
