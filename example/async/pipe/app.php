<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;
use Faker\Factory as FakerFactory;

require_once __DIR__ . '/../../bootstrap.php';

const RUNTIME = 60; // seconds

$spinner = Facade::createSpinner();

$loop = Facade::getLoop();

// let's generate random countries with a timestamp
$loop
    ->repeat(
        0.1,
        static function () use ($loop): void {
            // schedule random country generation
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

// let's stop loop after RUNTIME seconds
$loop
    ->delay(
        RUNTIME,
        static function () use ($loop): void {
            $loop->stop();
            Facade::getDriver()->finalize('Done.' . PHP_EOL);
        }
    )
;
