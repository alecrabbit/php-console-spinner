<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$spinner = SpinnerFactory::get();

$echoMessageToStdOut =
    static function (string $message) {
        echo $message;
    };

React\EventLoop\Loop::addPeriodicTimer(
    7,
    static function () use ($spinner, $echoMessageToStdOut) {
        $message =
            sprintf(
                '%s %s %s ',
                (new DateTimeImmutable())->format(DATE_ATOM),
                sprintf('Real Usage: %sK', number_format(memory_get_usage(true) / 1024,)),
                '(Message to stdout)',
            );
        $spinner->wrap($echoMessageToStdOut, $message);
    }
);

React\EventLoop\Loop::addPeriodicTimer(
    8,
    static function () use ($spinner, $echoMessageToStdOut) {
        $spinner->wrap($echoMessageToStdOut, PHP_EOL);
    }
);

React\EventLoop\Loop::addPeriodicTimer(
    2,
    static function () use ($spinner) {
        $rnd = random_int(10, 100000);
        if ($rnd < 30000) {
            $spinner->message(null);
            return;
        }

        $spinner->message(
            sprintf(
                'Used space: %sM',
                number_format(
                    $rnd / 1024
                )
            )
        );
    }
);

React\EventLoop\Loop::addPeriodicTimer(
    1,
    static function () use ($spinner) {
        $rnd = random_int(0, 100);
        if ($rnd < 30) {
            $spinner->progress(null);
            return;
        }
        $spinner->progress($rnd / 100);
    }
);

echo 'It spins...' . PHP_EOL;
