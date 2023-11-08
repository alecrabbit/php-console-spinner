<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

Facade::getSettings()
    ->set(
        new AuxSettings(
            normalizerOption: NormalizerOption::SLOW,
        ),
    )
;

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
