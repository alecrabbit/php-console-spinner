<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$outputSettings =
    new OutputSettings(
        stylingMethodOption: StylingMethodOption::ANSI24,
    );

Facade::getSettings()
    ->set($outputSettings)
;

$spinner = Facade::createSpinner();
