<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Builder\SpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$echoMessageToStdOut =
    static function (?string $message = null) {
        echo $message ?? '';
    };

$config =
    (new SpinnerConfigBuilder())
        ->inSynchronousMode()
        ->withFinalMessage('Done!' . PHP_EOL)
        ->build()
;

$spinner = SpinnerFactory::create($config);

$cb = static function () use ($spinner) {
    $spinner->spin();
};

$spinner->initialize();
for ($i = 0; $i < 100; $i++) {
    if (100 > random_int(0, 100000)) {
        $spinner->interrupt();
        break;
    }
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
    if ($i === 90) {
        $spinner->wrap($echoMessageToStdOut, 'Almost done...' . PHP_EOL);
    }
    $spinner->spin();
    usleep(100000);
}
$spinner->finalize();

echo PHP_EOL;
