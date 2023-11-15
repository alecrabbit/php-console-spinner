<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';



$spinnerSettings = new SpinnerSettings(autoAttach: false);

$driver = Facade::getDriver();
$loop = Facade::getLoop();

$spinnerOne = Facade::createSpinner($spinnerSettings);

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            stylePalette: new NoStylePalette(),
        )
    )
;

$spinnerTwo = Facade::createSpinner($spinnerSettings);

$loop->delay(
    1, // add spinner at
    static function () use ($driver, $spinnerOne): void {
        $driver->add($spinnerOne);
    }
);
$loop->delay(
    5, // add spinner at
    static function () use ($driver, $spinnerTwo): void {
        $driver->add($spinnerTwo);
    }
);

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
