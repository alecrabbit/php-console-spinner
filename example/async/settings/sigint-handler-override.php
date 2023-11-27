<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\Messages;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$handlerCreator =
    new class() implements IHandlerCreator {
        public function createHandler(IDriver $driver, ILoop $loop): Closure
        {
            $delay = 2;

            $message = PHP_EOL .
                'SIGINT handler overridden.' . PHP_EOL .
                'Will exit in ' . $delay . ' seconds.' . PHP_EOL .
                'CTRL+C to force exit.' . PHP_EOL;

            return static function () use ($driver, $loop, $delay, $message): void {
                $driver->interrupt($message);

                $loop->delay(
                    $delay,
                    static function () use ($loop): void {
                        $loop->stop();
                    }
                );

                $loop->onSignal(
                    SIGINT, // requires pcntl-ext
                    static function () use ($loop): void {
                        $loop->stop();
                    }
                );
            };
        }
    };

$creator =
    new SignalHandlerCreator(
        signal: SIGINT, // requires pcntl-ext
        handlerCreator: $handlerCreator,
    );

Facade::getSettings()
    ->set(
        new SignalHandlerSettings(
            $creator
        ),
        new DriverSettings(
            messages: new Messages(
                interruptionMessage: PHP_EOL . 'Custom interruption message.' . PHP_EOL, // note: will not be used
            )
        ),
    )
;

$spinner = Facade::createSpinner();
