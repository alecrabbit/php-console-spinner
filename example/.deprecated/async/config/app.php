<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Snake;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow;
use AlecRabbit\Spinner\StaticFacade;

require_once __DIR__ . '/../bootstrap.async.php';

// Settings
$runTime = 30; // s

$defaults = StaticDefaultsFactory::get();

//$defaults->getTerminalSettings()->overrideColorMode(StyleMode::ANSI24);

$config =
    StaticFacade::getConfigBuilder()
        ->withStylePattern(
            new Rainbow(
//                styleMode: StyleMode::ANSI8
            )
        )
        ->withCharPattern(new Snake())
        ->build();

$spinner =
    StaticFacade::createSpinner(
        $config
    );

$loop = StaticFacade::getLoop();

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
