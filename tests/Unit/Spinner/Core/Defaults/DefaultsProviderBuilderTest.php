<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\ILoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\ISpinnerSettingsBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class DefaultsProviderBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        self::assertTrue(true);

        $defaultsProviderBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DefaultsProviderBuilder::class, $defaultsProviderBuilder);
    }

    public function getTesteeInstance(
        ?ILoopSettingsBuilder $loopSettingsBuilder = null,
        ?ISpinnerSettingsBuilder $spinnerSettingsBuilder = null,
    ): IDefaultsProviderBuilder {
        return
            new DefaultsProviderBuilder(
                loopSettingsBuilder: $loopSettingsBuilder ?? $this->getLoopSettingsBuilderMock(),
                spinnerSettingsBuilder: $spinnerSettingsBuilder ?? $this->getSpinnerSettingsBuilderMock(),
            );
    }

    #[Test]
    public function canBuildDefaultsProvider(): void
    {
        self::assertTrue(true);

        $defaultsProvider = $this->getTesteeInstance()->build();

        self::assertInstanceOf(DefaultsProvider::class, $defaultsProvider);
    }
}
