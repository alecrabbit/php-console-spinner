<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);
/**
 * This example requires ext-pcntl
 */

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';

use AlecRabbit\Accessories\MemoryUsage;
use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\SnakeSpinner;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;
use React\Promise\Promise;
use function AlecRabbit\now;

// coloring output
$t = new Themes();

/**
 * This is an advanced example of using spinner.
 * Here we have a simple web server written with reactPHP.
 *
 * We're using SnakeSpinner.
 *
 * @link https://github.com/reactphp/http/blob/v0.8.4/examples/06-sleep.php
 */
$loop = Factory::create();
$server =
    new Server(
        static function (ServerRequestInterface $request) use ($loop) {
            if ('/favicon.ico' === $request->getRequestTarget()) {
                return
                    new Response(404);
            }
            return new Promise(static function ($resolve, $reject) use ($loop) {
                // Emulating processing response
                $loop->addTimer(0.2, static function () use ($resolve) {
                    $response =
                        new Response(
                            200,
                            [
                                'Content-Type' => 'text/html',
                                'charset' => 'utf-8',
                            ],
                            body()
                        );
                    $resolve($response);
                });
            });
        }
    );
$socket = new \React\Socket\Server($argv[1] ?? '0.0.0.0:8080', $loop);
$server->listen($socket);
echo PHP_EOL;

echo $t->comment('🚀 Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress())) . PHP_EOL;
echo PHP_EOL, $t->dark('Use CTRL+C to exit.'), PHP_EOL;

// Add SIGINT signal handler
$loop->addSignal(
    SIGINT,
    $func = static function ($signal) use ($loop, $t, &$func) {
        echo PHP_EOL, $t->dark('Exiting... (CTRL+C to force)'), PHP_EOL;
        $loop->removeSignal(SIGINT, $func);
        $loop->stop();
    }
);

/**
 * Spinner part
 */
$s = new SnakeSpinner();

// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    echo $s->spin();
});

// Add periodic timer to echo status message
$loop->addPeriodicTimer(60, static function () use ($s, $t) {
    echo $s->erase();
    echo Cursor::up();
    echo $t->dark(memory()) . PHP_EOL;
});

echo Cursor::hide();
echo PHP_EOL;
echo $t->dark(memory()) . PHP_EOL;

// Starting the loop
$loop->run();

echo $s->erase(); // Cleaning up
echo Cursor::show();


// ********************** Functions ****************************

function memory(): string
{
    $report = MemoryUsage::report();
    return now() . ' Memory usage: ' . $report->getUsageString();
}

function body(): string
{
    return '<html lang="en-US"><title>react</title><body><h1>Hello world!</h1><br>' . memory() . '</body></html>';
}


