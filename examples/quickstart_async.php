<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AlecRabbit\SpinnerOld\BlockSpinner;
use React\EventLoop\Factory;

$loop = Factory::create();

$s = new BlockSpinner();

$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    $s->spin();
});

$s->begin();

$loop->run();

