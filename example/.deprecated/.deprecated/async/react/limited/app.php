<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\StaticFacade;
use React\EventLoop\Loop;

require_once __DIR__ . '/../../bootstrap.async.php';

StaticDefaultsFactory::get()
    ->overrideLoopProbeClasses([ReactLoopProbe::class]); // probe only for ReactPHP event loop

/*
 * This example shows how you may use ReactPHP event loop.
 */
$spinner = StaticFacade::createSpinner();

$loop = Loop::get();
$loop->addTimer(3, static function () use ($loop, $spinner) {
    $spinner->finalize('Finished!' . PHP_EOL);
    $loop->addTimer(0.5, static function () use ($loop) {
        $loop->stop();
    });
});

//throw new \DomainException('Simulated error.'); // see [889ad594-ca28-4770-bb38-fd5bd8cb1777]
