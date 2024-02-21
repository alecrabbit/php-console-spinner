<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\LegacyNoStylePalette;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new WidgetSettings(
            leadingSpacer: new CharSequenceFrame('<>', 2), // <-- ignored spacer
        ),
        new RootWidgetSettings(
            leadingSpacer: new CharSequenceFrame('🧲 ', 3), // used this spacer instead
            stylePalette: new Rainbow(), // <-- ignored palette
        ),
    )
;

$widgetSettings =
    new WidgetSettings(
        stylePalette: new LegacyNoStylePalette(), // <-- used this palette instead
    );

$spinnerSettings =
    new SpinnerSettings(
        widgetSettings: $widgetSettings,
    );

$spinner = Facade::createSpinner($spinnerSettings);
