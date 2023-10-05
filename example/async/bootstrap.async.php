<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

require_once __DIR__ . '/../bootstrap.php';

// FIXME (2023-07-26 12:4) [Alec Rabbit]: Temporary workaround for Revolt loop not working
\AlecRabbit\Spinner\Probes::unregister(\AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe::class);
//\AlecRabbit\Spinner\Probes::unregister(\AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe::class);
//
//$settings = Facade::getSettings();
//$settings->set(new \AlecRabbit\Spinner\Core\Settings\AuxSettings(
//    runMethodOption: \AlecRabbit\Spinner\Contract\Option\RunMethodOption::SYNCHRONOUS,
//));

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

$memoryReport();

Facade::getLoop()
    ->repeat(
        $reportInterval,
        $memoryReport
    )
;
