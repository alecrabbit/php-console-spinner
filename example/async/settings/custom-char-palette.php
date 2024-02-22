<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\CustomCharPalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$interval = 250;
$reversed = true;

$options =
    new PaletteOptions(
        interval: $interval,
    );

$charPalette = new CustomCharPalette(
    frames:  new ArrayObject(
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
    options: new PaletteOptions(interval: 50),
);

$widgetSettings =
    new WidgetSettings(
        charPalette: $charPalette,
    );

$spinnerSettings =
    new SpinnerSettings(
        widgetSettings: $widgetSettings,
    );

$spinner = Facade::createSpinner($spinnerSettings);
