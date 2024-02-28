<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Probes;

require_once __DIR__ . '/../bootstrap.async.php';

// AutoStartOption can NOT be DISABLED for ReactPHP event loop
Probes::unregister(ReactLoopProbe::class);

$loopSettings =
    new LoopSettings(
        autoStartOption: AutoStartOption::DISABLED,
    );

Facade::getSettings()->set($loopSettings);


echo 'Will sleep for 1 second...' . PHP_EOL;
sleep(1);

$spinner = Facade::createSpinner();
echo 'Spinner created.' . PHP_EOL;

register_shutdown_function(
    static function (): void {
        echo 'Starting loop...' . PHP_EOL;
        // Loop autostart is disabled, so we need to do it manually
        Facade::getLoop()->run();
    }
);
