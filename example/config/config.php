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
        ->withFinalMessage('Final message: Done!')
        ->withInterval(new Interval(500))
        ->withShutdownDelay(0)
        ->withExitMessage('Exit message: Bye!')
        ->build()
;

$spinner = SpinnerFactory::create($config);

echo 'Starting...'. PHP_EOL;
