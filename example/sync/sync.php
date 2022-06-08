<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Builder\SpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$config =
    (new SpinnerConfigBuilder())
        ->inSynchronousMode()
        ->build()
;

$spinner = SpinnerFactory::create($config);

$spinner->begin();

dump($config, $spinner);

for($i = 0; $i < 100; $i++) {
    echo '_';
    $spinner->spin();
    usleep(100000);
    if($i === 30) {
        $spinner->message('0123456');
    }
    if($i === 40) {
        $spinner->progress(0.33);
    }
    if($i === 60) {
        $spinner->message('0123');
    }
}
$spinner->end();

dump($spinner);
