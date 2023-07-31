<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Builder;

use AlecRabbit\Spinner\Core\Settings\Builder\SettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SettingsProviderBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(SettingsProviderBuilder::class, $factory);
    }

    public function getTesteeInstance(): ISettingsProviderBuilder
    {
        return
            new  SettingsProviderBuilder();
    }

}
