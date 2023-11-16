<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\Messages;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

Facade::getSettings()
    ->set(
        new DriverSettings(
            messages: new Messages(
                finalMessage: '>>> Custom final message.' . PHP_EOL,
            )
        ),
    )
;

$driver = Facade::getDriver();
$loop = Facade::getLoop();

$loop
    ->delay(
        5, // seconds
        static function () use ($driver, $loop): void {
            $driver->finalize();
            $loop->stop();
        }
    )
;

$spinner = Facade::createSpinner();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';

//dump($spinner);
