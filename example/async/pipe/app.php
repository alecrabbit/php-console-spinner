<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;
use Faker\Factory as FakerFactory;

require_once __DIR__ . '/../../bootstrap.php';

const RUNTIME = 60; // seconds

$spinner = Facade::createSpinner();

$loop = Facade::getLoop();

// generate random countries with a timestamp
$loop
    ->repeat(
        0.1,
        // schedule random country generation
        static function () use ($loop): void {
            $loop->delay(
                random_int(1, 500) / 1000,
                static function (): void {
                    echo sprintf(
                            '%s: %s',
                            (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
                            FakerFactory::create()->country(),
                        ) . PHP_EOL;
                }
            );
        }
    )
;

// stop loop after RUNTIME seconds
$loop
    ->delay(
        RUNTIME,
        static function () use ($loop): void {
            $loop->stop();
            Facade::getDriver()->finalize('Done.' . PHP_EOL);
        }
    )
;
