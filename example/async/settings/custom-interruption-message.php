<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\Messages;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new DriverSettings(
            messages: new Messages(
                interruptionMessage: PHP_EOL . 'Custom interruption message.' . PHP_EOL,
            )
        ),
    )
;

echo PHP_EOL . 'Press CTRL+C to interrupt.' . PHP_EOL . PHP_EOL;

$spinner = Facade::createSpinner();
