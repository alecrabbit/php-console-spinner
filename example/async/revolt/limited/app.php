<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Factory\WidgetFactory;
use Revolt\EventLoop;

require_once __DIR__ . '/../../bootstrap.async.php';

DefaultsFactory::create()
    ->setLoopProbeClasses([RevoltLoopProbe::class]); // probe only for Revolt event loop

/*
 * This example shows how you may use Revolt event loop.
 */
$spinner = Factory::createSpinner();

EventLoop::delay(3, static function () use ($spinner) {
    $spinner->finalize('Finished!' . PHP_EOL);
    EventLoop::delay(0.5, static function () {
        exit();
    });
});

//throw new \DomainException('Simulated error.'); // see [889ad594-ca28-4770-bb38-fd5bd8cb1777]
