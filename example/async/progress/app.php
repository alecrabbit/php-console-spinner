<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\FractionValue;
use AlecRabbit\Spinner\Extras\ProgressWidgetFactory;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

require_once __DIR__ . '/../bootstrap.async.php';

// Settings
$runTime = 30; // s
$steps = 30;
$cycleInterval = 0.05; // s
$progressRefreshInterval = 800; // ms
$threshold = 900; // 90% [0..1000]

// Application
$faker = Faker\Factory::create();
$count = 0;

$defaults = DefaultsFactory::create();
//$defaults
//    ->setSpinnerStylePattern(new \AlecRabbit\Spinner\Core\Pattern\Style\TmpProceduralStylePattern())
//    ->setSpinnerCharPattern(new \AlecRabbit\Spinner\Core\Pattern\Char\TmpProceduralCharPattern())
//;

$spinner = Factory::createSpinner();

$progress = new FractionValue(steps: $steps, autoFinish: true);

$interval = new Interval($progressRefreshInterval);

$progressWidget = createProgressWidget($progress, $interval);

$spinner->add($progressWidget);

$loop = Factory::getLoop();

// Progress
$loop->repeat(
    $cycleInterval,
    static function () use ($spinner, $progress, $faker, $threshold, &$count) {
        if (!$progress->isFinished()) {
            if ($threshold < random_int(0, 1000)) {
                $spinner->wrap(
                    static function (string $message) {
                        echo $message . PHP_EOL;
                    },
                    sprintf(
                        '%s %s %s',
                        str_pad(sprintf('%s.', ++$count), 4, pad_type: STR_PAD_LEFT),
                        str_pad($faker->ipv6(), 40),
                        str_pad($faker->iban(), 35),
                    ),
                );
                $progress->advance();
            }
        }
    }
);

// Limits run time
$loop->delay(
    $runTime,
    static function () use ($spinner, $defaults, $loop) {
        $spinner->finalize('Finished!' . PHP_EOL);
        // Sets shutdown delay
        $loop->delay(
            $defaults->getShutdownDelay(),
            static function () use ($loop) {
                $loop->stop();
            }
        );
    }
);

function createProgressWidget(
    FractionValue $progress,
    Interval $interval
): IWidgetComposite {
    $composite = ProgressWidgetFactory::createSteps(
        $progress,
        updateInterval: $interval,
    );

    $composite->add(
        ProgressWidgetFactory::createProgressBar(
            $progress,
            updateInterval: $interval
        )
    );

    $composite->add(
        ProgressWidgetFactory::createProgressValue(
            $progress,
            updateInterval: $interval
        )
    );
    return $composite;
}