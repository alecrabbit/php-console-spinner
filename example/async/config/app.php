<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

Facade::getSettings()
    ->set(
        new OutputSettings(
            stylingMethodOption: StylingMethodOption::NONE,
        ),
        new DriverSettings()
    );

$spinner = Facade::createSpinner();

require_once __DIR__ . '/../bootstrap.async.php';

//dump($spinner);
