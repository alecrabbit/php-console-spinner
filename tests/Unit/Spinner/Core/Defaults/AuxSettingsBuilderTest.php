<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\LegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Settings\LegacyAuxSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class AuxSettingsBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyAuxSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(): ILegacyAuxSettingsBuilder
    {
        return new LegacyAuxSettingsBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyAuxSettingsBuilder::class, $builder);
        self::assertInstanceOf(LegacyAuxSettings::class, $builder->build());
    }
}
