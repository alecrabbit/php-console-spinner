<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Defaults\TerminalSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\TerminalSettingsFactory;
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

    public function getTesteeInstance(): ITerminalSettingsFactory
    {
        return new TerminalSettingsFactory();
    }

    #[Test]
    public function canCreateTerminalSettings(): void
    {
        $terminalSettings = $this->getTesteeInstance()->createTerminalSettings();

        self::assertInstanceOf(TerminalSettings::class, $terminalSettings);
    }
}
