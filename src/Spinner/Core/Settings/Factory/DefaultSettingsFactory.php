<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\LinkerSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;

final class DefaultSettingsFactory implements IDefaultSettingsFactory
{
    public function create(): ISettings
    {
        $settings = new Settings();

        $this->fill($settings);

        return $settings;
    }

    private function fill(ISettings $settings): void
    {
        // ATTENTION! MUST be filled with all required values
        $settings->set(
            new AuxSettings(
                runMethodOption: RunMethodOption::ASYNC,
                normalizerOption: NormalizerOption::BALANCED,
            ),
            new LinkerSettings(
                linkerOption: LinkerOption::ENABLED,
            ),
            new LoopSettings(
                autoStartOption: AutoStartOption::ENABLED,
                signalHandlingOption: SignalHandlingOption::ENABLED,
            ),
            new OutputSettings(
                stylingMethodOption: StylingMethodOption::ANSI8,
                cursorVisibilityOption: CursorVisibilityOption::HIDDEN,
                initializationOption: InitializationOption::ENABLED,
                stream: STDERR,
            ),
            new WidgetSettings(
                leadingSpacer: new CharFrame('', 0),
                trailingSpacer: new CharFrame(' ', 1),
                stylePalette: new NoStylePalette(),
                charPalette: new NoCharPalette(),
            ),
            new RootWidgetSettings(
                leadingSpacer: null,
                trailingSpacer: null,
                stylePalette: new Rainbow(),
                charPalette: new Snake(),
            ),
        );
    }
}
