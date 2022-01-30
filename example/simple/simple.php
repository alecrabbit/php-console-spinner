<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Factory\SpinnerFactory;

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

$socket = new React\Socket\SocketServer('0.0.0.0:8080');
$server->listen($socket);

$spinner = SpinnerFactory::create();

echo "Server running at http://0.0.0.0:8080" . PHP_EOL;
