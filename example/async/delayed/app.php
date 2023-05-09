<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$spinner = Facade::createSpinner(attach: false);
$driver = Facade::getDriver();
$loop = Facade::getLoop();

$loop->delay(5, static function () use ($driver, $loop, $spinner): void {
    $driver->add($spinner);
    $loop->delay(55, static function () use ($driver, $spinner): void {
        $driver->remove($spinner);
    });
});

$loop->delay(65, static function () use ($loop,$driver): void {
    $driver->finalize();
    $loop->stop();
});
