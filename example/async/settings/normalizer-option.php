<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new NormalizerSettings(
            normalizerOption: NormalizerOption::SLOW,
        ),
    )
;

$spinner = Facade::createSpinner();
