<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacySettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\LegacySettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Legacy\ILegacyTerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Legacy\ILegacyLoopSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacySettingsProvider;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SettingsProviderBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settingsProviderBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySettingsProviderBuilder::class, $settingsProviderBuilder);
    }

    public function getTesteeInstance(
        ?ILegacyLoopSettingsFactory $loopSettingsBuilder = null,
        ?ILegacyTerminalSettingsFactory $terminalSettingsFactory = null,
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

    protected function getLegacyDriverSettingsBuilderMock(): MockObject&ILegacyDriverSettingsBuilder
    {
        return $this->createMock(ILegacyDriverSettingsBuilder::class);
    }

    #[Test]
    public function canBuildSettingsProvider(): void
    {
        $settingsProvider = $this->getTesteeInstance()->build();

        self::assertInstanceOf(LegacySettingsProvider::class, $settingsProvider);
    }
}
