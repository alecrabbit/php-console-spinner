<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

if (!extension_loaded('pcntl')) {
    echo 'This example requires pcntl extension.' . PHP_EOL;
    exit(1);
}

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\SnakeSpinner;
use React\EventLoop\Factory;

// coloring output
$t = new Themes();
echo $t->dark('Use CTRL+C to exit.'), PHP_EOL;

$loop = Factory::create();

// Add SIGINT signal handler
$loop->addSignal(
    SIGINT,
    $func = static function ($signal) use ($loop, $t, &$func) {
        echo PHP_EOL, $t->dark('Exiting... (CTRL+C to force)'), PHP_EOL;
        $loop->removeSignal(SIGINT, $func);
        $loop->stop();
    }
);

$s = new SnakeSpinner();

// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    $s->spin();
});

$s->begin(); // Hides cursor and write first frame to output

// Starting the loop
$loop->run();

$s->end(); // Cleaning up
