<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Factory\SimpleSpinnerFactory;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Output\StreamOutput;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...); // echo function

Defaults::setSpinnerStylePattern(StylePattern::rainbowBg());

$config =
    (new ConfigBuilder())
        ->withCursor()
        ->withInterval(new Interval(10))
        ->build()
;

$spinner = SimpleSpinnerFactory::create($config);

$spinner->initialize();

$loop = $config->getLoop();

$loop->periodic(
    $spinner->getInterval()->toSeconds(),
    static function () use ($spinner) {
        $spinner->spin();
    }
);

$loop->defer(10, static function () use ($echo, $spinner, $loop) {
    $echo('Stopping...');
    $spinner->finalize();
    $loop->stop();
});

$echo('Starting...');

