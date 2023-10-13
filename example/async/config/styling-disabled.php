<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

// !!! ATTENTION !!!
// You can change settings ONLY BEFORE creating a configuration.
// Configuration is created only once at first call
// of:
// - Facade::getDriver()
// - Facade::getLoop()
// - Facade::createSpinner()

// so lets disable styling:
Facade::getSettings()
    ->set(
        new OutputSettings(
            stylingMethodOption: StylingMethodOption::NONE,
        ),
    )
;


$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';

//dump($spinner);
