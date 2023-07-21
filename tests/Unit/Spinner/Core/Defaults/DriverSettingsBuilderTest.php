<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\LegacyDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyDriverSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverSettingsBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyDriverSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(): ILegacyDriverSettingsBuilder
    {
        return new LegacyDriverSettingsBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyDriverSettingsBuilder::class, $builder);
        self::assertInstanceOf(LegacyDriverSettings::class, $builder->build());
    }
}
