<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\ExecutionModeOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Option\StylingModeOption;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILinkerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\INormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Factory\DefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\LinkerSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DefaultSettingsFactoryTest extends TestCase
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

        $generalSettings = $settings->get(IGeneralSettings::class);
        $normalizerSettings = $settings->get(INormalizerSettings::class);
        $linkerSettings = $settings->get(ILinkerSettings::class);
        $loopSettings = $settings->get(ILoopSettings::class);
        $outputSettings = $settings->get(IOutputSettings::class);
        $widgetSettings = $settings->get(IWidgetSettings::class);
        $rootWidgetSettings = $settings->get(IRootWidgetSettings::class);

        self::assertInstanceOf(GeneralSettings::class, $generalSettings);
        self::assertInstanceOf(NormalizerSettings::class, $normalizerSettings);
        self::assertInstanceOf(LinkerSettings::class, $linkerSettings);
        self::assertInstanceOf(LoopSettings::class, $loopSettings);
        self::assertInstanceOf(OutputSettings::class, $outputSettings);
        self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
        self::assertInstanceOf(RootWidgetSettings::class, $rootWidgetSettings);

        self::assertEquals(ExecutionModeOption::ASYNC, $generalSettings->getExecutionModeOption());
        self::assertEquals(NormalizerOption::BALANCED, $normalizerSettings->getNormalizerOption());

        self::assertEquals(LinkerOption::ENABLED, $linkerSettings->getLinkerOption());

        self::assertEquals(AutoStartOption::ENABLED, $loopSettings->getAutoStartOption());
        self::assertEquals(SignalHandlingOption::ENABLED, $loopSettings->getSignalHandlingOption());

        self::assertEquals(StylingModeOption::ANSI8, $outputSettings->getStylingModeOption());
        self::assertEquals(CursorVisibilityOption::HIDDEN, $outputSettings->getCursorVisibilityOption());

        self::assertEquals(new CharSequenceFrame('', 0), $widgetSettings->getLeadingSpacer());
        self::assertEquals(new CharSequenceFrame(' ', 1), $widgetSettings->getTrailingSpacer());
        self::assertEquals(new NoStylePalette(), $widgetSettings->getStylePalette());
        self::assertEquals(new NoCharPalette(), $widgetSettings->getCharPalette());

        self::assertNull($rootWidgetSettings->getLeadingSpacer());
        self::assertNull($rootWidgetSettings->getTrailingSpacer());
        self::assertEquals(new Rainbow(), $rootWidgetSettings->getStylePalette());
        self::assertEquals(new Snake(), $rootWidgetSettings->getCharPalette());
    }
}
