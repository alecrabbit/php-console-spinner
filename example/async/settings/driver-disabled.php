<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\DriverOption;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

$driverSettings =
    new DriverSettings(
        driverOption: DriverOption::DISABLED,
    );

Facade::getSettings()
    ->set(
        $driverSettings,
    )
;

$spinner = Facade::createSpinner();
