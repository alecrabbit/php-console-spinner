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

echo sprintf('Server running at http://%s', $uri) . PHP_EOL;
