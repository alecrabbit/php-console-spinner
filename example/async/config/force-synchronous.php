<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

Facade::getSettings()
    ->set(
        new GeneralSettings(
            runMethodOption: RunMethodOption::SYNCHRONOUS,
        ),
    )
;

$spinner = Facade::createSpinner();

$driver = Facade::getDriver();

echo 'Synchronous mode forced' . PHP_EOL;

// Will throw:
//Facade::getLoop()->run();

for ($i = 0; $i < 1000; $i++) {
    $driver->render();
    usleep(random_int(1000, 500000)); // simulates unequal intervals
}
$driver->finalize();

echo 'Finished' . PHP_EOL;
