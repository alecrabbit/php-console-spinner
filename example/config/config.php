<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Builder\SpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Rotor\Interval;

use const AlecRabbit\Cli\TERM_NOCOLOR;

const MILLISECONDS = 250;
const STOP_IN = 5.456353567; // seconds int|float

require_once __DIR__ . '/../bootstrap.php';

$config =
    (new SpinnerConfigBuilder())
        ->withColorSupportLevel(TERM_NOCOLOR)
        ->doNotHideCursor()
        ->withFinalMessage('This is the final message.' . PHP_EOL)
        ->withInterval(new Interval(MILLISECONDS))
        ->withShutdownDelay(0)
        ->withInterruptMessage('Interrupted!' . PHP_EOL)
        ->build()
;

$spinner = SpinnerFactory::create($config);

$loop = $config->getLoop();
$loop->defer(
    STOP_IN,
    function () use ($loop, $spinner) {
        $loop->stop();
        $spinner->finalize();
        echo PHP_EOL;
    }
);

echo 'Starting...' . PHP_EOL;
echo sprintf('Refresh interval: %s ms', MILLISECONDS) . PHP_EOL;
echo sprintf('Will stop in %s seconds', number_format(STOP_IN, 2)) . PHP_EOL;
