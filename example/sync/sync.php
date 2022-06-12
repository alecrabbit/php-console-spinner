<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Builder\SpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

use const AlecRabbit\Cli\TERM_NOCOLOR;

require_once __DIR__ . '/../bootstrap.php';

$config =
    (new SpinnerConfigBuilder())
        ->inSynchronousMode()
        ->build()
;

$spinner = SpinnerFactory::create($config);

$spinner->begin();

for ($i = 0; $i < 100; $i++) {
    if ($i % 10 === 0) {
        echo '_';
    }
    $spinner->spin();
    if ($i === 30) {
        $spinner->message('0123456');
    }
    if ($i === 40) {
        $spinner->progress(0.4);
    }
    if ($i === 60) {
        $spinner->message('0123');
    }
    if ($i === 80) {
        $spinner->progress(0.8);
    }
    usleep(100000);
}
$spinner->end();


echo PHP_EOL;
