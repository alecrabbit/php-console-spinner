<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Extras\FractionValue;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

require_once __DIR__ . '/../bootstrap.async.php';

// Settings
$runTime = 20;
$steps = 40;
$advanceInterval = 0.1;


$defaults = DefaultsFactory::create();

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

$composite = \AlecRabbit\Spinner\Extras\ProgressWidgetFactory::createSteps(
    $progress,
    updateInterval: $interval,
);

$composite->add(
    \AlecRabbit\Spinner\Extras\ProgressWidgetFactory::createProgressBar(
        $progress,
        updateInterval: $interval
    )
);

$composite->add(
    \AlecRabbit\Spinner\Extras\ProgressWidgetFactory::createProgressValue(
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
