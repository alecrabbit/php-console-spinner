<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

require_once __DIR__ . '/../bootstrap.async.php';

$loop = Facade::getLoop();

$reportInterval = 5;

$memoryReport = static function (): void {
    static $m = new MemoryUsage();
    $message =
        sprintf(
            '%s %s',
            (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
            $m->report(),
        );
    echo $message . PHP_EOL;
};

$loop->repeat(
    $reportInterval,
    $memoryReport
);

echo '--' . PHP_EOL;
$memoryReport();

$spinner = Facade::createSpinner(attach: false);
$driver = Facade::getDriver();

dump($driver);
dump($loop);

$loop->delay(7, static function () use ($driver, $loop, $spinner): void {
    $driver->add($spinner);
    $loop->delay(12, static function () use ($driver, $spinner): void {
        $driver->remove($spinner);
    });
});
