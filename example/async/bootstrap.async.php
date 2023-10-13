<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

// Code in this file is NOT REQUIRED
// and is used only for demonstration convenience.

require_once __DIR__ . '/../bootstrap.php'; // <-- except this line - it is required 🙂

$reportInterval = 60; // seconds

$driver = Facade::getDriver();

// Create echo function
$echo =
    $driver->wrap(
        static function (?string $message = null) {
            echo $message . PHP_EOL;
        }
    );

// Create memory report function
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

$loop = Facade::getLoop();

// Execute memory report function every $reportInterval seconds
$loop
    ->repeat(
        $reportInterval,
        $memoryReport
    )
;

$echo(PHP_EOL . sprintf('Using loop: "%s"', get_debug_type($loop)));
$echo();

$memoryReport(); // initial report
