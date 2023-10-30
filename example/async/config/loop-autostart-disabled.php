<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Probes;

require_once __DIR__ . '/../../bootstrap.php';

// AutoStartOption can NOT be disabled for ReactPHP event loop
Probes::unregister(ReactLoopProbe::class);

$loopSettings =
    new LoopSettings(
        autoStartOption: AutoStartOption::DISABLED,
    );

Facade::getSettings()->set($loopSettings);

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';

// Loop autostart is disabled, so we need to run loop manually
Facade::getLoop()->run();
