<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
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
    public function canCreateReturnsEmptySettings(): void
    {
        $factory = $this->getTesteeInstance();

        $settings = $factory->create();

        self::assertInstanceOf(Settings::class, $settings);

        $auxSettings = $settings->get(IAuxSettings::class);
        $driverSettings = $settings->get(IDriverSettings::class);
        $loopSettings = $settings->get(ILoopSettings::class);
        $outputSettings = $settings->get(IOutputSettings::class);
        $widgetSettings = $settings->get(IWidgetSettings::class);
        $rootWidgetSettings = $settings->get(IRootWidgetSettings::class);

        self::assertNull($auxSettings);
        self::assertNull($driverSettings);
        self::assertNull($loopSettings);
        self::assertNull($outputSettings);
        self::assertNull($widgetSettings);
        self::assertNull($rootWidgetSettings);
    }
}
