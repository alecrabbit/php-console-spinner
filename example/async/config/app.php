<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Pattern\Char\Snake;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

// Settings
$runTime = 30; // s


$defaults = DefaultsFactory::get();

$config =
    Facade::getConfigBuilder()
        ->withCharPattern(new Snake())
        ->build();

$spinner =
    SpinnerFactory::createSpinner(
        $config
    );

$loop = SpinnerFactory::getLoop();

// Limits run time
$loop->delay(
    $runTime,
    static function () use ($spinner, $defaults, $loop) {
        $spinner->finalize('Finished!' . PHP_EOL);
        // Sets shutdown delay
        $loop->delay(
            $defaults->getShutdownDelay(),
            static function () use ($loop) {
                $loop->stop();
            }
        );
    }
);
