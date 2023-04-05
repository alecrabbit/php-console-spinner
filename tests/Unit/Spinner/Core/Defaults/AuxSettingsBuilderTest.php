<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\AuxSettings;
use AlecRabbit\Spinner\Core\Defaults\AuxSettingsBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class AuxSettingsBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(AuxSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(): IAuxSettingsBuilder
    {
        return
            new AuxSettingsBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(AuxSettingsBuilder::class, $builder);
        self::assertInstanceOf(AuxSettings::class, $builder->build());
    }
}
