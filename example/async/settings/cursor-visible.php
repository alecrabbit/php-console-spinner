<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new OutputSettings(
            cursorVisibilityOption: CursorVisibilityOption::VISIBLE,
        ),
    )
;

$spinner = Facade::createSpinner();
