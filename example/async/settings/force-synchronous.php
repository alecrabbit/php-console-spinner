<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

$cycles = 100;
$min = 1000;
$max = 500000;

Facade::getSettings()
    ->set(
        new GeneralSettings(
            runMethodOption: RunMethodOption::SYNCHRONOUS,
        ),
    )
;

$spinner = Facade::createSpinner();

$driver = Facade::getDriver();

echo 'Synchronous mode forced.' . PHP_EOL;
echo 'Runtime: ' . ($cycles * $min / 1e6) . '..' . ($cycles * $max / 1e6) . 's' . PHP_EOL;

// Will throw:
//Facade::getLoop()->run();

for ($i = 0; $i < $cycles; $i++) {
    $driver->render();
    usleep(random_int($min, $max)); // simulates unequal intervals
}
$driver->finalize('Finished.' . PHP_EOL);
