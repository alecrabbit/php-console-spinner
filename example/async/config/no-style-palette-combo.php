<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

$widgetSettings =
    new WidgetSettings(
        stylePalette: new NoStylePalette(),
    );

$spinnerSettings =
    new SpinnerSettings(
        widgetSettings: $widgetSettings,
    );

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            trailingSpacer: new CharFrame(' 💨', 3),
        )
    )
;

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';

//dump($spinner);
