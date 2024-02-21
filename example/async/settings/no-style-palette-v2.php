<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Palette\LegacyNoStylePalette;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            stylePalette: new LegacyNoStylePalette(),
        )
    )
;

$spinner = Facade::createSpinner();
