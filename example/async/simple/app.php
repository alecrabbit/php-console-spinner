<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$config =
    Facade::getConfigBuilder()
        ->build()
;

$loop = Facade::getLoop();

$spinner = Facade::createSpinner($config);

// that's it :)

//dump($spinner, $config, $loop);
dump($spinner);

$spinner->initialize();
echo 'Start!' . PHP_EOL;

$loop->delay(
    $delay = 1,
    static function () use ($delay): void {
        echo sprintf('Delayed for %ss.', $delay) . PHP_EOL;
    }
);
$loop->delay(
    5,
    static function () use ($loop): void {
        $loop->stop();
        echo 'Stopped!' . PHP_EOL;
    }
);

$loop->repeat(
    $spinner->getInterval()->toSeconds(),
    static function () use ($spinner): void {
        $spinner->spin();
    }
);

$loop->run();
