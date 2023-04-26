<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Defaults\TerminalSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\TerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class TerminalSettingsFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $terminalSettingsFactory = $this->getTesteeInstance();

        self::assertInstanceOf(TerminalSettingsFactory::class, $terminalSettingsFactory);
    }

    public function getTesteeInstance(
        ?ITerminalProbe $terminalProbe = null,
    ): ITerminalSettingsFactory {
        return new TerminalSettingsFactory(
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
            ->willReturn(OptionCursor::HIDDEN)
        ;
        $terminalProbe
            ->expects(self::once())
            ->method('getOptionStyleMode')
            ->willReturn(OptionStyleMode::ANSI4)
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

        self::assertInstanceOf(TerminalSettings::class, $terminalSettings);
    }
}
