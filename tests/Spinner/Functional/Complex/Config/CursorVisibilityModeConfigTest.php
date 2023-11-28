<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class CursorVisibilityModeConfigTest extends ConfigurationTestCase
{
    #[Test]
    public function canSetCursorVisibilityOptionVisible(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    cursorVisibilityOption: CursorVisibilityOption::VISIBLE,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(CursorVisibilityMode::VISIBLE, $outputConfig->getCursorVisibilityMode());
    }

    public function canSetCursorVisibilityOptionHidden(): void
    {
        Facade::getSettings()
            ->set(
                new OutputSettings(
                    cursorVisibilityOption: CursorVisibilityOption::HIDDEN,
                ),
            )
        ;

        /** @var IOutputConfig $outputConfig */
        $outputConfig = self::getRequiredConfig(IOutputConfig::class);

        self::assertSame(CursorVisibilityMode::HIDDEN, $outputConfig->getCursorVisibilityMode());
    }
}
