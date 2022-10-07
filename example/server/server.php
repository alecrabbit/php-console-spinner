<?php

declare(strict_types=1);

// 07.10.22

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

// Server
$server = new React\Http\HttpServer(
    static function (Psr\Http\Message\RequestInterface $_) {
        return new React\Http\Message\Response(
            200,
            [
                'Content-Type' => 'text/plain',
            ],
            sprintf("Responded at %s\n", (new DateTimeImmutable())->format('Y-m-d H:i:s.u')),
        );
    }
);

$uri = '0.0.0.0:8080';
$socket = new React\Socket\SocketServer($uri);
$server->listen($socket);

// Spinner
$config =
    (new ConfigBuilder())
        ->withCursor()
        ->withInterval(new Interval(10))
        ->build()
;

$spinner = SpinnerFactory::create($config);
