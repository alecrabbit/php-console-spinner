<?php
declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$uri = '0.0.0.0:8080';

$spinner = SpinnerFactory::create();

$server = new React\Http\HttpServer(
    static function (Psr\Http\Message\RequestInterface $request) {
        return new React\Http\Message\Response(
            200,
            array(
                'Content-Type' => 'text/plain'
            ),
            sprintf ("Responded at %s\n", date('Y-m-d H:i:s'))
        );
    }
);

$socket = new React\Socket\SocketServer($uri);
$server->listen($socket);

echo sprintf('Server running at http://%s', $uri) . PHP_EOL;
