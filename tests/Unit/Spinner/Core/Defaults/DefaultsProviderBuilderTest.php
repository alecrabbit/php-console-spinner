<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\DefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\DefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DefaultsProviderBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $defaultsProviderBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DefaultsProviderBuilder::class, $defaultsProviderBuilder);
    }

    public function getTesteeInstance(
        ?ILoopSettingsFactory $loopSettingsBuilder = null,
        ?ITerminalSettingsFactory $terminalSettingsFactory = null,
        ?IAuxSettingsBuilder $auxSettingsBuilder = null,
        ?IDriverSettingsBuilder $driverSettingsBuilder = null,
    ): IDefaultsProviderBuilder {
        return
            new DefaultsProviderBuilder(
                loopSettingsFactory: $loopSettingsBuilder ?? $this->getLoopSettingsFactoryMock(),
                terminalSettingsFactory: $terminalSettingsFactory ?? $this->getTerminalSettingsFactoryMock(),
                auxSettingsBuilder: $auxSettingsBuilder ?? $this->getAuxSettingsBuilderMock(),
                driverSettingsBuilder: $driverSettingsBuilder ?? $this->getDriverSettingsBuilderMock(),
            );
    }

    #[Test]
    public function canBuildDefaultsProvider(): void
    {
        $defaultsProvider = $this->getTesteeInstance()->build();

        self::assertInstanceOf(DefaultsProvider::class, $defaultsProvider);
    }
}
