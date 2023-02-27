<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\FractionValue;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

//use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe; // uncomment this line to use ReactPHP event loop

require_once __DIR__ . '/../bootstrap.async.php';

// Settings
$runTime = 20;
$steps = 40;
$advanceInterval = 0.1;


// Tune Defaults
$defaults = DefaultsFactory::create();
// in dev environment we have both ReactPHP and Revolt event loops (see require-dev section in composer.json),
// so we need to specify which one to use.
$probes = [RevoltLoopProbe::class]; // probe only for Revolt event loop
//$probes = [ReactLoopProbe::class]; // probe only for ReactPHP event loop

$defaults
    ->setLoopProbes($probes) // specify which event loop to use
//    ->setAttachSignalHandlers(false) // disable signal handling
;

// Application
$faker = Faker\Factory::create();
$count = 0;

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

$loop->repeat($advanceInterval, static function () use ($spinner, $progress, $faker, &$count) {
    if (!$progress->isFinished()) {
        $spinner->wrap(
            function (string $message) {
                echo $message . PHP_EOL;
            },
            sprintf(
                '%s %s %s',
                str_pad(sprintf('%s.', ++$count), 4, pad_type: STR_PAD_LEFT),
                str_pad($faker->iban(), 35),
                str_pad($faker->ipv6(), 40),
            ),
        );
        $progress->advance();
    }
});

// Limits run time
$loop->delay($runTime, static function () use ($spinner, $defaults, $loop) {
    $spinner->finalize('Finished!' . PHP_EOL);
    // Sets shutdown delay
    $loop->delay($defaults->getShutdownDelay(), static function () use ($loop) {
        $loop->stop();
    });
});
