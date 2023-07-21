<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacySettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\LegacySettingsProviderBuilder;
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

        self::assertInstanceOf(LegacySettingsProviderBuilder::class, $settingsProviderBuilder);
    }

    public function getTesteeInstance(
        ?ILoopSettingsFactory $loopSettingsBuilder = null,
        ?ITerminalSettingsFactory $terminalSettingsFactory = null,
        ?ILegacyAuxSettingsBuilder $auxSettingsBuilder = null,
        ?ILegacyDriverSettingsBuilder $driverSettingsBuilder = null,
    ): ILegacySettingsProviderBuilder {
        return
            new LegacySettingsProviderBuilder(
                loopSettingsFactory: $loopSettingsBuilder ?? $this->getLoopSettingsFactoryMock(),
                terminalSettingsFactory: $terminalSettingsFactory ?? $this->getTerminalSettingsFactoryMock(),
                auxSettingsBuilder: $auxSettingsBuilder ?? $this->getLegacyAuxSettingsBuilderMock(),
                driverSettingsBuilder: $driverSettingsBuilder ?? $this->getLegacyDriverSettingsBuilderMock(),
            );
    }

    #[Test]
    public function canBuildSettingsProvider(): void
    {
        $settingsProvider = $this->getTesteeInstance()->build();

        self::assertInstanceOf(LegacySettingsProvider::class, $settingsProvider);
    }
}
