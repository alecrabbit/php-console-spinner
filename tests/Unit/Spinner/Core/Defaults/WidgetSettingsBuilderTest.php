<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\WidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\WidgetSettingsBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class WidgetSettingsBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(): IWidgetSettingsBuilder
    {
        return
            new WidgetSettingsBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettingsBuilder::class, $builder);
        self::assertInstanceOf(WidgetSettings::class, $builder->build());
    }
}
