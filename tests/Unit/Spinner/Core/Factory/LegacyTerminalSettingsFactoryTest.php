<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyTerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\LegacyTerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyTerminalSettings;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalLegacyProbe;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

/**
 * @deprecated Will be removed
 */
final class LegacyTerminalSettingsFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $terminalSettingsFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyTerminalSettingsFactory::class, $terminalSettingsFactory);
    }

    public function getTesteeInstance(
        ?ITerminalLegacyProbe $terminalProbe = null,
    ): ILegacyTerminalSettingsFactory {
        return new LegacyTerminalSettingsFactory(
            terminalProbe: $terminalProbe ?? $this->getTerminalProbeMock(),
        );
    }

    #[Test]
    public function canCreateTerminalSettings(): void
    {
        $terminalProbe = $this->getTerminalProbeMock();
        $terminalProbe
            ->expects(self::once())
            ->method('getOptionCursor')
            ->willReturn(CursorVisibilityOption::HIDDEN)
        ;
        $terminalProbe
            ->expects(self::once())
            ->method('getOptionStyleMode')
            ->willReturn(StylingMethodOption::ANSI4)
        ;
        $terminalProbe
            ->expects(self::once())
            ->method('getOutputStream')
            ->willReturn(STDERR)
        ;
        $terminalSettings =
            $this->getTesteeInstance(terminalProbe: $terminalProbe)
                ->createTerminalSettings()
        ;

        self::assertInstanceOf(LegacyTerminalSettings::class, $terminalSettings);
    }
}
