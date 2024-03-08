<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Contract\Option\CursorOption;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class CursorModeConfigTest extends ConfigurationTestCase
{
    #[Test]
    public function canSetCursorOptionVisible(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    cursorOption: CursorOption::VISIBLE,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(CursorMode::VISIBLE, $outputConfig->getCursorMode());
    }

    public function canSetCursorOptionHidden(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    cursorOption: CursorOption::HIDDEN,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(CursorMode::HIDDEN, $outputConfig->getCursorMode());
    }
}
