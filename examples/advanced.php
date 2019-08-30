<?php declare(strict_types=1);

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';
require_once __DIR__ . '/__include/__ext_check.php';

__check_for_extension('pcntl', 'ext-pcntl is required', __FILE__);

use AlecRabbit\Accessories\MemoryUsage;
use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Settings\Settings;
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
            echo date('D Y-m-d H:i:s') . ' ' . $request->getHeader('user-agent')[0] . PHP_EOL;
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
$settings = new Settings();
$settings
    ->setFrames(Frames::SNAKE_VARIANT_1)
    ->setStyles(
        [
            Juggler::MESSAGE_STYLES =>
                [
                    Juggler::COLOR256 => StylesInterface::C256_YELLOW_WHITE,
                    Juggler::COLOR => [Styles::WHITE],
                ],
        ]
    );
$s = new SnakeSpinner($settings, null);

// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    $s
        ->message(date('D Y-m-d H:i:s'))
        ->spin();
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
    $report = MemoryUsage::getReport();
    return now() . ' Memory usage: ' . $report->getUsageString();
}

function body(): string
{
    return '<html lang="en-US"><title>' . basename(__FILE__) . ' demo</title><body><h1>Hello world!</h1><br>' . memory() . '</body></html>';
}


