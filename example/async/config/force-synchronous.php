<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

Facade::getSettings()
    ->set(
        new AuxSettings(
            runMethodOption: RunMethodOption::SYNCHRONOUS,
        ),
    )
;

$spinner = Facade::createSpinner();

$driver = Facade::getDriver();

echo 'Synchronous mode forced' . PHP_EOL;

for ($i = 0; $i < 100; $i++) {
    $driver->render();
    \usleep(100000);
}
$driver->finalize();

echo 'Finished' . PHP_EOL;
