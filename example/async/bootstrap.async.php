<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

require_once __DIR__ . '/../bootstrap.php';

$driver = Facade::getDriver();
$echo =
    $driver->wrap(
        static function (string $message) {
            echo $message . PHP_EOL;
        }
    );

$reportInterval = 60;

$memoryReport = static function () use ($echo): void {
    static $m = new MemoryUsage();

    $echo(
        sprintf(
            '%s %s',
            (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
            $m->report(),
        )
    );
};

$echo('--');

$memoryReport();
$loop = Facade::getLoop();

//dump($loop);
//dump($driver);
//dump($spinner);

$loop->repeat(
    $reportInterval,
    $memoryReport
);
