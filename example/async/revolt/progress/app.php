<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\FractionValue;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;
use Revolt\EventLoop;

require_once __DIR__ . '/../../bootstrap.php';

$defaults = DefaultsFactory::create();
$defaults
    ->setLoopProbes([RevoltLoopProbe::class]) // probe only for Revolt event loop
//    ->setAttachSignalHandlers(false) // disable signal handling
;

$spinner = Factory::createSpinner();

$progress =
    new FractionValue(
        steps: 20,
        autoFinish: true
    );

$spinner->add(
    Factory\ProgressWidgetFactory::createSteps($progress)
);
EventLoop::repeat(0.2, static function () use ($progress) {
    $progress->advance();
});

EventLoop::delay(40, static function () use ($spinner, $defaults) {
    $spinner->finalize('Finished!' . PHP_EOL);
    EventLoop::delay($defaults->getShutdownDelay(), static function () {
        exit();
    });
});
