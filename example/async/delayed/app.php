<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

// disable auto-attach
$spinnerSettings = new SpinnerSettings(autoAttach: false);

$driver = Facade::getDriver();
$loop = Facade::getLoop();

$spinner = Facade::createSpinner($spinnerSettings);

$loop->delay(
    5, // add spinner at
    static function () use ($driver, $spinner): void {
        $driver->add($spinner);
    }
);

$loop->delay(
    25, // remove spinner at
    static function () use ($driver, $spinner): void {
        $driver->remove($spinner);
    }
);

$loop->delay(
    30, // stop loop at
    static function () use ($driver, $loop): void {
        $driver->finalize();
        $loop->stop();
    }
);
