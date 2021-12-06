<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

/*
 * This demo is a simple web server.
 *
 * Please ignore code quality :)
 */

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';
require_once __DIR__ . '/__include/__ext_check.php';

__check_for_extension('pcntl', 'ext-pcntl is required', __FILE__);

use AlecRabbit\ConsoleColour\Contracts\Color;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\SpinnerOld\Core\Contracts\Frames;
use AlecRabbit\SpinnerOld\Core\Contracts\Juggler;
use AlecRabbit\SpinnerOld\Core\Contracts\Styles;
use AlecRabbit\SpinnerOld\Dot8BitSpinner;
use AlecRabbit\SpinnerOld\Settings\Contracts\Defaults;
use AlecRabbit\SpinnerOld\Settings\Settings;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

const DATETIME_FORMAT = 'D Y-m-d H:i:s';

// coloring output
$t = new Themes();

/**
 * This is an advanced spinner usage example.
 * Here we have a simple web server written with reactPHP.
 *
 * We're using SnakeSpinner.
 *
 * @link https://github.com/reactphp/http/blob/v0.8.4/examples/06-sleep.php
 */
$loop = Factory::create();
$server =
    new Server(
        static function (ServerRequestInterface $request) use ($loop, $t, &$s) {
            if ('/favicon.ico' === $request->getRequestTarget()) {
                return
                    new Response(404);
            }
            // "log" request
            $ip = $request->getServerParams()['REMOTE_ADDR'];
            echo $t->dark(date(DATETIME_FORMAT)) . ' ' . $t->cyan($ip) . ' ' . $request->getHeader('user-agent')[0] . PHP_EOL;
            $s->spin();
//            // return response after pause
//            return new Promise(static function ($resolve, $reject) use ($loop) {
//                // Emulating processing response
//                $loop->addTimer(0.02, static function () use ($resolve) {
//                    $response =
//                        new Response(
//                            200,
//                            [
//                                'Content-Type' => 'text/html',
//                                'charset' => 'utf-8',
//                            ],
//                            body()
//                        );
//                    $resolve($response);
//                });
//            });
            // return response immediately
            return
                new Response(
                    200,
                    [
                        'Content-Type' => 'text/html',
                        'charset' => 'utf-8',
                    ],
                    body()
                );
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
    $func = static function ($signal) use ($loop, $t, &$func, &$s) {
        $s->erase();
        echo PHP_EOL, $t->dark('Exiting... (CTRL+C to force)'), PHP_EOL;
        $loop->removeSignal(SIGINT, $func);
        $loop->stop();
    }
);

/**
 * Spinner part
 */
$settings = new Settings();
$settings
    ->setMessageSuffix(Defaults::EMPTY_STRING)
//    ->setFrames(Frames::SNAKE_VARIANT_1) // override frames setting
    // let's change jugglers order
    // Note: Juggler::PROGRESS is not used in this example
    ->setJugglersOrder([Juggler::PROGRESS, Juggler::MESSAGE, Juggler::FRAMES])
    ->setStyles(
        [
            Juggler::MESSAGE_STYLES =>
                [
                    Juggler::COLOR256 => Styles::C256_YELLOW_WHITE,
                    Juggler::COLOR => [Color::WHITE],
                ],
        ]
    );
// overriding defaults with $settings
$s = new Dot8BitSpinner($settings);

// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    // Note next periodic timer - we are changing message in a different "coroutine"
    $s->spin();
});

// We are changing spinner message in a different "coroutine" with it's own interval
$loop->addPeriodicTimer(1, static function () use ($s) {
    $s->message(date(DATETIME_FORMAT));
});

// Add periodic timer to echo status message
$loop->addPeriodicTimer(900, static function () use ($t) {
    echo $t->dark(memory()) . PHP_EOL;
});

echo PHP_EOL;
echo $t->dark(memory()) . PHP_EOL;
$s->begin();

// Starting the loop
$loop->run();

$s->end(); // Cleaning up


// ********************** Functions ****************************

function memory(): string
{
    return date(DATETIME_FORMAT) . ' Memory usage: ' . memory_get_usage(true);
}

function body(): string
{
    return
        '<html lang="en-US"><title>' .
        basename(__FILE__) .
        ' demo</title><body><h1>Hello world!</h1><br>' .
        memory() .
        '</body></html>';
}


