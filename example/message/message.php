<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$server = new React\Http\HttpServer(
    static function (Psr\Http\Message\ServerRequestInterface $request) {
        return new React\Http\Message\Response(
            200,
            array(
                'Content-Type' => 'text/plain'
            ),
            "Hello World!\n"
        );
    }
);

$uri = '0.0.0.0:8080';
$socket = new React\Socket\SocketServer($uri);
$server->listen($socket);

$spinner = SpinnerFactory::get();

React\EventLoop\Loop::addPeriodicTimer(
    7,
    static function () use ($spinner) {
        $date = (new DateTimeImmutable())->format(DATE_ATOM);
        $spinner->erase();
        echo sprintf(
            '%s %s ',
            $date,
            '(Message to stdout)',
        );
        $spinner->spin();
    }
);

React\EventLoop\Loop::addPeriodicTimer(
    8,
    static function () use ($spinner) {
        $spinner->erase();
        echo PHP_EOL;
        $spinner->spin();
    }
);

React\EventLoop\Loop::addPeriodicTimer(
    1,
    static function () use ($spinner) {
        $rnd = random_int(10, 100000000);
        if ($rnd < 30000000) {
            $spinner->message(null);
            return;
        }

        $spinner->message(
            sprintf(
                'Memory: %sK',
                number_format(
                    $rnd / 1024
                )
            )
        );
    }
);

React\EventLoop\Loop::addPeriodicTimer(
    0.5,
    static function () use ($spinner) {
        $rnd = random_int(0, 100);
        if ($rnd < 30) {
            $spinner->progress(null);
            return;
        }
        $spinner->progress($rnd / 100);
    }
);

echo sprintf('Server running at http://%s', $uri) . PHP_EOL;
