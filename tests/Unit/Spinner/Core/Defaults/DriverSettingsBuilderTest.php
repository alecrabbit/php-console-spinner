<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\DriverSettings;
use AlecRabbit\Spinner\Core\Defaults\DriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class DriverSettingsBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(): IDriverSettingsBuilder
    {
        return
            new DriverSettingsBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSettingsBuilder::class, $builder);
        self::assertInstanceOf(DriverSettings::class, $builder->build());
    }
}
