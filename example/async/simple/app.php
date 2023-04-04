<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$spinner = Facade::createSpinner();

// that's it :)

//dump($spinner, $config, $loop);
//dump($spinner);

$loop = Facade::getLoop();

echo 'Start!' . PHP_EOL;

$loop->delay(
    5,
    static function () use ($loop,$spinner): void {
        $loop->stop();
        $spinner->finalize();
        echo 'Stopped!' . PHP_EOL;
    }
);


$loop->run();
