<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\Factory\UserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class UserSettingsFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
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
    public function canCreateFilled(): void
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

        self::assertInstanceOf(AuxSettings::class, $auxSettings);
        self::assertInstanceOf(DriverSettings::class, $driverSettings);
        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertInstanceOf(OutputSettings::class, $outputSettings);
        self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
        self::assertInstanceOf(RootWidgetSettings::class, $rootWidgetSettings);

        self::assertEquals(RunMethodOption::AUTO, $auxSettings->getRunMethodOption());
        self::assertEquals(NormalizerOption::AUTO, $auxSettings->getNormalizerOption());

        self::assertEquals(LinkerOption::AUTO, $driverSettings->getLinkerOption());
        self::assertEquals(InitializationOption::AUTO, $driverSettings->getInitializationOption());

        self::assertEquals(AutoStartOption::AUTO, $loopSettings->getAutoStartOption());
        self::assertEquals(SignalHandlersOption::AUTO, $loopSettings->getSignalHandlersOption());

        self::assertEquals(StylingMethodOption::AUTO, $outputSettings->getStylingMethodOption());
        self::assertEquals(CursorVisibilityOption::AUTO, $outputSettings->getCursorVisibilityOption());

        self::assertNull($widgetSettings->getLeadingSpacer());
        self::assertNull($widgetSettings->getTrailingSpacer());
        self::assertNull($widgetSettings->getStylePalette());
        self::assertNull($widgetSettings->getCharPalette());

        self::assertNull($rootWidgetSettings->getLeadingSpacer());
        self::assertNull($rootWidgetSettings->getTrailingSpacer());
        self::assertNull($rootWidgetSettings->getStylePalette());
        self::assertNull($rootWidgetSettings->getCharPalette());
    }
}
