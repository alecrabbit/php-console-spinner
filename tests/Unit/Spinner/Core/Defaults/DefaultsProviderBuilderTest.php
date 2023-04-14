<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\DefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
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
        ?IAuxSettingsBuilder $auxSettingsBuilder = null,
        ?IDriverSettingsBuilder $driverSettingsBuilder = null,
        ?IWidgetSettingsBuilder $widgetSettingsBuilder = null,
        ?IWidgetSettingsBuilder $rootWidgetSettingsBuilder = null,
    ): IDefaultsProviderBuilder {
        return
            new DefaultsProviderBuilder(
                loopSettingsFactory: $loopSettingsBuilder ?? $this->getLoopSettingsBuilderMock(),
                auxSettingsBuilder: $auxSettingsBuilder ?? $this->getAuxSettingsBuilderMock(),
                driverSettingsBuilder: $driverSettingsBuilder ?? $this->getDriverSettingsBuilderMock(),
                widgetSettingsBuilder: $widgetSettingsBuilder ?? $this->getWidgetSettingsBuilderMock(),
                rootWidgetSettingsBuilder: $rootWidgetSettingsBuilder ?? $this->getWidgetSettingsBuilderMock(),
            );
    }

    #[Test]
    public function canBuildDefaultsProvider(): void
    {
        $defaultsProvider = $this->getTesteeInstance()->build();

        self::assertInstanceOf(DefaultsProvider::class, $defaultsProvider);
    }
}
