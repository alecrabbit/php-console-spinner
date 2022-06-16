<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Rotor\Interval;

use const AlecRabbit\Cli\TERM_NOCOLOR;

const REFRESH_INTERVAL = 250; // milliseconds int
const STOP_SCRIPT_IN = 5.4; // seconds int|float

require_once __DIR__ . '/../bootstrap.php';

$config =
    (new ConfigBuilder())
        ->withTerminalColor(TERM_NOCOLOR)
        ->withCursor()
        ->withFinalMessage('This is the final message.' . PHP_EOL)
        ->withInterval(new Interval(REFRESH_INTERVAL))
        ->withShutdownDelay(0)
        ->withInterruptMessage('Interrupted!' . PHP_EOL)
        ->build()
;

$spinner = SpinnerFactory::create($config);
dump($spinner);

$loop = $config->getLoop();
$loop->defer(
    STOP_SCRIPT_IN,
    function () use ($loop, $spinner) {
        $loop->stop();
        $spinner->finalize();
        echo PHP_EOL;
        dump($spinner);
    }
);

echo 'Starting...' . PHP_EOL;
echo sprintf('Refresh interval: %s ms', REFRESH_INTERVAL) . PHP_EOL;
echo sprintf('Will stop in %s seconds', number_format(STOP_SCRIPT_IN, 2)) . PHP_EOL;

