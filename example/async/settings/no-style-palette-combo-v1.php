<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            leadingSpacer: new CharSequenceFrame('<>', 2), // <-- ignored
            trailingSpacer: new CharSequenceFrame(' 💨', 3),
        )
    )
;

$widgetSettings =
    new WidgetSettings(
        leadingSpacer: new CharSequenceFrame('', 0), // <-- used this instead
        stylePalette: new NoStylePalette(),
    );

$spinnerSettings =
    new SpinnerSettings(
        widgetSettings: $widgetSettings,
    );

$spinner = Facade::createSpinner($spinnerSettings);
