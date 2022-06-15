<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);

$echoMessageToStdOut = $stdout->writeln(...);

$echoMessageToStdOut('Started...');
$echoMessageToStdOut('But may be interrupted...');

$config =
    (new ConfigBuilder())
        ->inSynchronousMode()
        ->withFinalMessage('Done!' . PHP_EOL)
        ->build()
;

$spinner = SpinnerFactory::create($config);

$spinner->initialize();
for ($i = 0; $i < 100; $i++) {
    if (500 > random_int(0, 100000)) {
        $spinner->interrupt();
        break;
    }
    if ($i === 20) {
        $spinner->message('0123456');
    }
    if ($i === 33) {
        $spinner->progress(0.33);
    }
    if ($i === 50) {
        $spinner->progress(0.5);
        $spinner->wrap($echoMessageToStdOut, 'More than a half!' . PHP_EOL);
    }
    if ($i === 60) {
        $spinner->progress(0.6);
        $spinner->message('0123');
    }
    if ($i === 80) {
        $spinner->progress(0.8);
    }
    if ($i === 90) {
        $spinner->wrap($echoMessageToStdOut, 'Almost done...' . PHP_EOL);
    }
    $spinner->spin();
    usleep(100000);
}
$spinner->finalize();

echo PHP_EOL;
