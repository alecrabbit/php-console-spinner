<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Factory;
use React\EventLoop\Loop;

require_once __DIR__ . '/../../bootstrap.async.php';

DefaultsFactory::create()
    ->setLoopProbeClasses([ReactLoopProbe::class]); // probe only for ReactPHP event loop

/*
 * This example shows how you may use ReactPHP event loop.
 */
$spinner = Factory::createSpinner();

$loop = Loop::get();
$loop->addTimer(3, static function () use ($loop, $spinner) {
    $spinner->finalize('Finished!' . PHP_EOL);
    $loop->addTimer(0.5, static function () use ($loop) {
        $loop->stop();
    });
});

//throw new \DomainException('Simulated error.'); // see [889ad594-ca28-4770-bb38-fd5bd8cb1777]
