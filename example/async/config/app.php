<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';


$settings = Facade::getSettings();

dump($settings);

$settings
    ->set(
        new OutputSettings(
            stylingMethodOption: StylingMethodOption::NONE,
        ),
        new DriverSettings()
    );

dump($settings);

dump(Facade::getSettings());

$spinner = Facade::createSpinner();

dump(Facade::getSettings());
//dump($spinner);
