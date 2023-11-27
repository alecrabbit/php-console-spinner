<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$interval = 500;
$reversed = true;

$options =
    new PaletteOptions(
        interval: $interval,
        reversed: $reversed,
    );

$charPalette = new Snake($options);

$widgetSettings =
    new WidgetSettings(
        charPalette: $charPalette,
    );

$spinnerSettings =
    new SpinnerSettings(
        widgetSettings: $widgetSettings,
    );

// Optionally you can disable styling:
{
    $outputSettings =
        new OutputSettings(
            stylingMethodOption: StylingMethodOption::NONE,
        );

    Facade::getSettings()
        ->set($outputSettings)
    ;
}

$spinner = Facade::createSpinner($spinnerSettings);
