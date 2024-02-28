<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\CustomStylePalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$stylePalette = new CustomStylePalette(
    frames: new ArrayObject(
        [
            new StyleSequenceFrame("\e[91m%s\e[39m",0),
            new StyleSequenceFrame("\e[94m%s\e[39m",0),
        ]
    ),
    options: new PaletteOptions(interval: 1000),
);

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            leadingSpacer: new CharSequenceFrame('🧲 ', 3), // used this spacer instead
            stylePalette: $stylePalette,
        ),
    )
;

$spinner = Facade::createSpinner();
