<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

Facade::getSettings()
    ->set(
        new LoopSettings(
            autoStartOption: AutoStartOption::DISABLED,
        ),
    )
;

$spinner = Facade::createSpinner();

//// Loop autostart disabled, so we need to run it manually
Facade::getLoop()->run();
