<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

$handlerCreator =
    new class implements IHandlerCreator {
        public function createHandler(IDriver $driver, ILoop $loop): Closure
        {
            return
                static function () use ($driver, $loop): void {
                    $delay = 2;
                    $message = PHP_EOL .
                        'SIGINT handler overridden.' . PHP_EOL .
                        'Will exit in ' . $delay . ' seconds.' . PHP_EOL .
                        'CTRL+C to force exit.' . PHP_EOL;

                    $driver->interrupt($message);

                    $loop->delay(
                        $delay,
                        static function () use ($loop): void {
                            $loop->stop();
                        }
                    );

                    $loop->onSignal(
                        SIGINT,
                        static function () use ($loop): void {
                            $loop->stop();
                        }
                    );
                };
        }
    };

Facade::getSettings()
    ->set(
        new SignalHandlerSettings(
            new SignalHandlerCreator(
                signal: SIGINT, // requires pcntl-ext
                handlerCreator: $handlerCreator,
            )
        ),
    )
;

$spinner = Facade::createSpinner();
