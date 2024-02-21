<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Palette\LegacyNoStylePalette;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$widgetSettings =
    new WidgetSettings(
        stylePalette: new LegacyNoStylePalette(),
    );

$spinnerSettings =
    new SpinnerSettings(
        widgetSettings: $widgetSettings,
    );
$spinner = Facade::createSpinner($spinnerSettings);
