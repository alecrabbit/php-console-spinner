<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...); // echo function

$config =
    (new ConfigBuilder())
        ->withCursor()
        ->withInterval(new Interval(10))
        ->build()
;

$spinner = SpinnerFactory::create($config);

$spinner->initialize();

$echo('Starting...');

$config->getLoop()->defer(2, function () use ($echo) {
    $echo('Stopping...');
});
