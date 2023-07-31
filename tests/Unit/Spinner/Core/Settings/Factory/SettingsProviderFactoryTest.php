<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\SettingsProviderFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SettingsProviderFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(SettingsProviderFactory::class, $factory);
    }

    public function getTesteeInstance(): ISettingsProviderFactory
    {
        return
            new SettingsProviderFactory();
    }

}
