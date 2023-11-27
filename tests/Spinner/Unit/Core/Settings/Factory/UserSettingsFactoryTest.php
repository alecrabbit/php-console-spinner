<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\UserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class UserSettingsFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(UserSettingsFactory::class, $factory);
    }

    public function getTesteeInstance(): IUserSettingsFactory
    {
        return
            new UserSettingsFactory();
    }


    #[Test]
    public function canCreate(): void
    {
        $factory = $this->getTesteeInstance();

        $settings = $factory->create();

        self::assertInstanceOf(Settings::class, $settings);
    }
}
