<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Probes;
use AlecRabbit\Spinner\Facade;

// note required file
require_once __DIR__ . '/../../bootstrap.php';

$cycles = 100;
$min = 1000; // 1ms
$max = 500000;  // 500ms

// bootstrap.sync.php has this line:
Probes::unregister(ILoopProbe::class);
echo 'All loop probes disabled.' . PHP_EOL;

$spinner = Facade::createSpinner();

$driver = Facade::getDriver();

echo 'Runtime: ' . ($cycles * $min / 1e6) . '..' . ($cycles * $max / 1e6) . 's' . PHP_EOL;

// Will throw:
//Facade::getLoop()->run();

for ($i = 0; $i < $cycles; $i++) {
    $driver->render();
    usleep(random_int($min, $max)); // simulates unequal intervals
}
$driver->finalize('Finished.' . PHP_EOL);
