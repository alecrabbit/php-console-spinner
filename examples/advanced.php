<?php declare(strict_types=1);
/**
 * This example requires ext-pcntl
 */
require __DIR__ . '/../vendor/autoload.php';

use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\SnakeSpinner;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;
use React\Promise\Promise;
use function AlecRabbit\now;

/**
 * This is an advanced example of using spinner.
 * Here we have a simple web server written with reactPHP.
 *
 * We're using SnakeSpinner.
 *
 * @link https://github.com/reactphp/http/blob/v0.8.4/examples/06-sleep.php
 */
$loop = Factory::create();
$server = new Server(static function (ServerRequestInterface $request) use ($loop) {
    return new Promise(static function ($resolve, $reject) use ($loop) {
        // Emulating slow server
        $loop->addTimer(0.6, static function () use ($resolve) {
            $response =
                new Response(200, ['Content-Type' => 'text/plain',], now() . ' Hello world!');
            $resolve($response);
        });
    });
});
$socket = new \React\Socket\Server($argv[1] ?? '0.0.0.0:8080', $loop);
$server->listen($socket);
echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;
echo 'Use CTRL+C to exit.' . PHP_EOL;

// Add SIGINT signal handler
$loop->addSignal(SIGINT, static function ($signal) use ($loop) {
    echo PHP_EOL;
    echo 'Exiting... ', PHP_EOL;
    $loop->stop();
});

/**
 * Spinner part
 */
$s = new SnakeSpinner();

// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer(0.08, static function () use ($s) {
    echo $s->spin();
});

echo Cursor::hide();

// Starting the loop
$loop->run();

echo $s->erase(); // Cleaning up
echo Cursor::show();
