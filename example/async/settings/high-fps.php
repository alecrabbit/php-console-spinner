<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\CustomCharPalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$interval = 10;

Facade::getSettings()
    ->set(
        new NormalizerSettings(
            normalizerOption: NormalizerOption::SMOOTH,
        ),
    )
;

$charPalette = new CustomCharPalette(
    frames: new ArrayObject(
        [
            new CharSequenceFrame('   ', 3),
            new CharSequenceFrame('.  ', 3),
            new CharSequenceFrame('.. ', 3),
            new CharSequenceFrame('...', 3),
            new CharSequenceFrame(' ..', 3),
            new CharSequenceFrame('  .', 3),
            new CharSequenceFrame('   ', 3),
        ]
    ),
    options: new PaletteOptions(
        interval: $interval,
    ),
);

$spinner = Facade::createSpinner(
    new SpinnerSettings(
        widgetSettings: new WidgetSettings(
            charPalette: $charPalette,
        ),
    )
);
