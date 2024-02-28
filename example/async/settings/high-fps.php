<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$interval = 10;

Facade::getSettings()
    ->set(
        new NormalizerSettings(
            normalizerOption: NormalizerOption::EXTREME,
        ),
    )
;

$spinner = Facade::createSpinner(
    new SpinnerSettings(
        widgetSettings: new WidgetSettings(
            charPalette: new Snake(
                options: new PaletteOptions(
                    interval: $interval,
                ),
            ),
        ),
    ),
);
