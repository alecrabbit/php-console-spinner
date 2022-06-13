<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Builder\SpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

use AlecRabbit\Spinner\Core\Rotor\Interval;

use const AlecRabbit\Cli\TERM_NOCOLOR;

require_once __DIR__ . '/../bootstrap.php';

$config =
    (new SpinnerConfigBuilder())
        ->withColorSupportLevel(TERM_NOCOLOR)
        ->doNotHideCursor()
        ->withFinalMessage('Done!')
        ->withInterval(new Interval(100))
        ->withShutdownDelay(0)
        ->withExitMessage('Bye!')
        ->build()
;

$spinner = SpinnerFactory::create($config);

echo 'Starting...'. PHP_EOL;
