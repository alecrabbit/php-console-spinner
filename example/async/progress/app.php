<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\FractionValue;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

require_once __DIR__ . '/../bootstrap.async.php';

// Settings
$runTime = 40;
$steps = 40;
$advanceInterval = 0.2;
$advanceSteps = 6;

// Application
$defaults = DefaultsFactory::create();
$defaults
//    ->setLoopProbes([RevoltLoopProbe::class]) // probe only for Revolt event loop
    ->setLoopProbes([ReactLoopProbe::class]) // probe only for ReactPHP event loop
    ->setAttachSignalHandlers(false) // disable signal handling
;

$spinner = Factory::createSpinner();

$progress =
    new FractionValue(
        steps: $steps,
        autoFinish: true
    );

$interval =
    new Interval(
        $advanceInterval * 1000
    );

$composite = Factory\ProgressWidgetFactory::createSteps(
    $progress,
    updateInterval: $interval,
);

$composite->add(
    Factory\ProgressWidgetFactory::createProgressBar(
        $progress,
        updateInterval: $interval
    )
);

$composite->add(
    Factory\ProgressWidgetFactory::createProgressValue(
        $progress,
        updateInterval: $interval
    )
);

$spinner->add($composite);

$loop = Factory::getLoop();

$loop->repeat($advanceInterval, static function () use ($progress, $advanceSteps) {
    $progress->advance($advanceSteps);
});

// Limits run time
$loop->delay($runTime, static function () use ($spinner, $defaults, $loop) {
    $spinner->finalize('Finished!' . PHP_EOL);
    // Sets shutdown delay
    $loop->delay($defaults->getShutdownDelay(), static function () use ($loop) {
        $loop->stop();
    });
});
