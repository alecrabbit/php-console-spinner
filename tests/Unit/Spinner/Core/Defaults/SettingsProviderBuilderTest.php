<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\SettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\LegacySettingsProvider;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SettingsProviderBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $settingsProviderBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(SettingsProviderBuilder::class, $settingsProviderBuilder);
    }

    public function getTesteeInstance(
        ?ILoopSettingsFactory $loopSettingsBuilder = null,
        ?ITerminalSettingsFactory $terminalSettingsFactory = null,
        ?IAuxSettingsBuilder $auxSettingsBuilder = null,
        ?IDriverSettingsBuilder $driverSettingsBuilder = null,
    ): ISettingsProviderBuilder {
        return
            new SettingsProviderBuilder(
                loopSettingsFactory: $loopSettingsBuilder ?? $this->getLoopSettingsFactoryMock(),
                terminalSettingsFactory: $terminalSettingsFactory ?? $this->getTerminalSettingsFactoryMock(),
                auxSettingsBuilder: $auxSettingsBuilder ?? $this->getAuxSettingsBuilderMock(),
                driverSettingsBuilder: $driverSettingsBuilder ?? $this->getDriverSettingsBuilderMock(),
            );
    }

    #[Test]
    public function canBuildSettingsProvider(): void
    {
        $settingsProvider = $this->getTesteeInstance()->build();

        self::assertInstanceOf(LegacySettingsProvider::class, $settingsProvider);
    }
}
