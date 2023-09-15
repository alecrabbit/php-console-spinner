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
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\Factory\DefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DefaultSettingsFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(DefaultSettingsFactory::class, $factory);
    }

    public function getTesteeInstance(): IDefaultSettingsFactory
    {
        return
            new DefaultSettingsFactory();
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

        self::assertEquals(RunMethodOption::ASYNC, $auxSettings->getRunMethodOption());
        self::assertEquals(NormalizerOption::BALANCED, $auxSettings->getNormalizerOption());

        self::assertEquals(LinkerOption::ENABLED, $driverSettings->getLinkerOption());
        self::assertEquals(InitializationOption::ENABLED, $driverSettings->getInitializationOption());

        self::assertEquals(AutoStartOption::ENABLED, $loopSettings->getAutoStartOption());
        self::assertEquals(SignalHandlersOption::ENABLED, $loopSettings->getSignalHandlersOption());

        self::assertEquals(StylingMethodOption::ANSI8, $outputSettings->getStylingMethodOption());
        self::assertEquals(CursorVisibilityOption::HIDDEN, $outputSettings->getCursorVisibilityOption());

        self::assertEquals(new CharFrame('', 0), $widgetSettings->getLeadingSpacer());
        self::assertEquals(new CharFrame(' ', 1), $widgetSettings->getTrailingSpacer());
        self::assertNull($widgetSettings->getStylePalette());
        self::assertNull($widgetSettings->getCharPalette());

        self::assertNull($rootWidgetSettings->getLeadingSpacer());
        self::assertNull($rootWidgetSettings->getTrailingSpacer());
        self::assertEquals(new Rainbow(), $rootWidgetSettings->getStylePalette());
        self::assertEquals(new Snake(), $rootWidgetSettings->getCharPalette());
    }
}
