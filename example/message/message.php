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

$spinner = SpinnerFactory::create();

React\EventLoop\Loop::addPeriodicTimer(
    5,
    static function () use ($spinner) {
        $date = (new DateTimeImmutable())->format(DATE_ATOM);
        echo "Message showing current datetime: {$date}";
        $spinner->spin();
    }
);

React\EventLoop\Loop::addPeriodicTimer(
    6,
    static function () use ($spinner) {
        $spinner->erase();
        echo PHP_EOL;
        $spinner->spin();
    }
);

React\EventLoop\Loop::addPeriodicTimer(
    3.2,
    static function () use ($spinner) {
        $memory = memory_get_usage() / 1024;
        $formatted = number_format($memory) . 'K';
        $str = "Current memory usage: {$formatted}";
        $spinner->message($str);
    }
);

echo sprintf('Server running at http://%s', $uri) . PHP_EOL;
