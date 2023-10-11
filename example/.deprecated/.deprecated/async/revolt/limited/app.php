<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\StaticFacade;
use Revolt\EventLoop;

require_once __DIR__ . '/../../bootstrap.async.php';

StaticDefaultsFactory::get()
    ->overrideLoopProbeClasses([RevoltLoopProbe::class]); // probe only for Revolt event loop

/*
 * This example shows how you may use Revolt event loop.
 */
$spinner = StaticFacade::createSpinner();

EventLoop::delay(3, static function () use ($spinner) {
    $spinner->finalize('Finished!' . PHP_EOL);
    EventLoop::delay(0.5, static function () {
        exit();
    });
});

//throw new \DomainException('Simulated error.'); // see [889ad594-ca28-4770-bb38-fd5bd8cb1777]
