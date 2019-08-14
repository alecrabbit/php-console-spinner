<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AlecRabbit\Spinner\BlockSpinner;
use React\EventLoop\Factory;

$loop = Factory::create();

//$loop->addSignal(
//    SIGINT,
//    $func = static function ($signal) use ($loop, &$func) {
//        $loop->removeSignal(SIGINT, $func);
//        $loop->stop();
//    }
//);

$s = new BlockSpinner();

$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    $s->spin();
});

$s->begin();

$loop->run();

$s->end();
