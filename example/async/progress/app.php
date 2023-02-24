<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\FractionValue;
use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

require_once __DIR__ . '/../bootstrap.php';

$runTime = 40;
$advanceInterval = 0.2;
$steps = 20;

$defaults = DefaultsFactory::create();
$defaults
//    ->setLoopProbes([RevoltLoopProbe::class]) // probe only for Revolt event loop
    ->setLoopProbes([ReactLoopProbe::class]) // probe only for ReactPHP event loop
//    ->setAttachSignalHandlers(false) // disable signal handling
;

$spinner = Factory::createSpinner();

$progress =
    new FractionValue(
        steps: $steps,
        autoFinish: true
    );

$spinner->add(
    Factory\ProgressWidgetFactory::createSteps($progress)
);

$loop = Factory::getLoop();

$loop->repeat($advanceInterval, static function () use ($progress) {
    $progress->advance();
});

$loop->delay($runTime, static function () use ($spinner, $defaults, $loop) {
    $spinner->finalize('Finished!' . PHP_EOL);
    $loop->delay($defaults->getShutdownDelay(), static function () use ($loop) {
        $loop->stop();
    });
});
