<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Aesthetic;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\ProgressValue;
use AlecRabbit\Spinner\Extras\StaticProgressWidgetFactory;
use AlecRabbit\Spinner\StaticFacade;

require_once __DIR__ . '/../bootstrap.async.php';

// Settings
$runTime = 30; // s
$steps = 20;
$cycleInterval = 0.05; // s
$progressRefreshInterval = 800; // ms
$threshold = 900; // 90% [0..1000]

// Application
$faker = Faker\Factory::create();
$count = 0;

$defaults = StaticDefaultsFactory::get();
$defaults
    ->setCharPattern(new \AlecRabbit\Spinner\Extras\Procedure\TmpProceduralCharPattern())
//    ->setSpinnerCharPattern(new \AlecRabbit\Spinner\Core\Pattern\Char\Custom(['o', 'O' ], 100))
//    ->setCharPattern(        new Aesthetic(reversed: true)    )
    //    ->setSpinnerStylePattern(new \AlecRabbit\Spinner\Extras\Procedure\TmpProceduralStylePattern())
;

$spinner = StaticFacade::createSpinner();

$progress = new ProgressValue(steps: $steps, autoFinish: true);

$interval = new Interval($progressRefreshInterval);

$progressWidget = createProgressWidget($progress, $interval);

$spinner->add($progressWidget);

$loop = StaticFacade::getLoop();

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
    ProgressValue $progress,
    Interval $interval
): IWidgetComposite {
    $composite = StaticProgressWidgetFactory::createProgressSteps(
        $progress,
        updateInterval: $interval,
    );

    $composite->add(
        StaticProgressWidgetFactory::createProgressBar(
            $progress,
            updateInterval: $interval
        )
    );

    $composite->add(
        StaticProgressWidgetFactory::createProgressValue(
            $progress,
            updateInterval: $interval
        )
    );
    
    $composite->add(
        StaticProgressWidgetFactory::createProgressFrame(
            $progress,
            updateInterval: $interval
        )
    );
    return $composite;
}