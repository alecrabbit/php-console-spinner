<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

/*
 * This demo shows how your app may look like.
 * It can print out your data and change spinner messages.
 *
 * Please ignore code quality :)
 */

//require_once __DIR__ . '/../vendor/autoload.php';         // Uncomment this line if you didn't clone this repository
require_once __DIR__ . '/../tests/bootstrap.php';           // and comment this one
require_once __DIR__ . '/__include/__ext_check.php';
require_once __DIR__ . '/__include/__async_demo.php';       // Functions for this demo
require_once __DIR__ . '/__include/__functions.php';       // Functions for this demo

use AlecRabbit\Cli\Tools\Core\TerminalStatic;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\Core\Adapters\SymfonyOutputAdapter;
use React\EventLoop\Factory;
use Symfony\Component\Console\Output\ConsoleOutput;

// This example requires pcntl extension
__check_for_extension('pcntl', 'ext-pcntl is required', __FILE__);

// Creating Symfony console output
$consoleOutput = new ConsoleOutput();

// Separated stream for piping support
$stderr = $consoleOutput->getErrorOutput();

// Coloring output
$t = new Themes(true);


// Welcoming message
$stderr->writeln($t->lightCyan('Async spinner demo.'));

// For faking data
$faker = Faker\Factory::create();

// Initial progress value
$progress = null;

// Get spinner variant argument
$variant = (int)($argv[1] ?? 0);
$inline = (bool)($argv[2] ?? false);

if ($inline) {
    $stderr->writeln($t->warning(
        'Inline spinner mode should only be used with short spinner messages or no messages(to avoid artefacts)!'
    ));
}
$stderr->writeln('');

$output = new SymfonyOutputAdapter($consoleOutput);

// Get spinner
$s = spinnerFactory($variant, $output);
$s->inline($inline); // set spinner inline mode

$output = $s->getOutput();

$colorSupport = TerminalStatic::colorSupport();
// Get messages for spinner
$messages = messages($colorSupport);

$finalMessage = $t->lightGreen('Finished!') . PHP_EOL;

// Event loop
$loop = Factory::create();

// Add SIGINT signal handler
$loop->addSignal(
    SIGINT,
    $func = static function ($signal) use ($loop, $t, &$func, $s, &$finalMessage, $stderr) {
        $s->erase();
        $stderr->writeln(['', $t->dark('Exiting... (CTRL+C to force)')]);
        $loop->removeSignal(SIGINT, $func);
        $finalMessage = $t->lightRed('Interrupted!') . PHP_EOL;
        $loop->stop();
    }
);

// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    $s->spin();
});

// Add periodic timer to simulate messages from your app
$loop->addPeriodicTimer(0.2, static function () use ($s, $t, $inline, $faker, &$progress) {
    if ((16 < $progress) && (random_int(0, 100) > 50)) {
        $s->erase();
        simulateMessage($inline, $t, $faker);
        $s->last(); // optional, for smooth animation
    }
});

// Add periodic timer to print out memory usage - examples of messages form other part of app
$loop->addPeriodicTimer(8, static function () use ($s, $t, $inline, &$progress, $stderr) {
    if (16 < $progress) {
        $s->erase();
        memory($t, $inline, $stderr);
        $s->last(); // optional
    }
});

// Add timer to disable spinner
$loop->addTimer(18, static function () use ($s, &$progress, $stderr) {
    if (16 < $progress) {
        if ($s->isActive()) {
            $s->disable();
        }
        $s->erase();
        $stderr->writeln('*** Spinner disabled ***');
//        $s->last(); // optional
    }
});

// Add timer to disable spinner
$loop->addTimer(28, static function () use ($s, &$progress, $stderr) {
    if (16 < $progress) {
        if (!$s->isActive()) {
            $s->enable();
        }
        $s->erase();
        $stderr->writeln('*** Spinner enabled ***');
        $s->last(); // optional
    }
});

// Add periodic timer to increment $progress - simulating setting updating progress during execution
$loop->addPeriodicTimer(0.5, static function () use ($s, $loop, &$progress) {
    if (null === $progress) {
        $progress = 0;
    }
    if (++$progress > 100) {
        $loop->stop();
    }
    if (70 <= $progress && $progress <= 79) {
        $s->progress(null);
    } else {
        $s->progress($progress / 100);
    }
});

// Simulating setting custom message during execution
$loop->addPeriodicTimer(0.3, static function () use ($s, &$progress, $messages) {
    $progress = $progress ?? 0;
    if (null !== $progress && \array_key_exists($progress, $messages)) {
        $s->message($messages[$progress]);
    }
});

$stderr->writeln($t->dark('Use CTRL+C to exit.') . PHP_EOL);

$stderr->writeln('Searching for accepted payments...');

$s->begin(); // Hides cursor and write first frame to output

// Starting the loop
$loop->run();

$s->end($finalMessage); // Cleaning up
$stderr->writeln('');
