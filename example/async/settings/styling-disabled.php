<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$outputSettings =
    new OutputSettings(
        stylingModeOption: StylingOption::NONE,
    );

Facade::getSettings()
    ->set($outputSettings)
;

$spinner = Facade::createSpinner();
