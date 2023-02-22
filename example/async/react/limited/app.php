<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;
use React\EventLoop\Loop;

require_once __DIR__ . '/../../bootstrap.php';

DefaultsFactory::create()
    ->setLoopProbes([ReactLoopProbe::class]); // probe only for ReactPHP event loop

/*
 * This example shows how to use ReactPHP event loop.
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
