<?php
declare(strict_types=1);

use AlecRabbit\Spinner\Spinner;
use AlecRabbit\Spinner\SpinnerConfig;

require_once __DIR__ . '/../vendor/autoload.php';


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

$socket = new React\Socket\Server('0.0.0.0:8080');
$server->listen($socket);


$config = new SpinnerConfig();

$s = new Spinner($config);

echo "Server running at http://0.0.0.0:8080" . PHP_EOL;
