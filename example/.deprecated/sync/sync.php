<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Kernel\Factory\WSpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);

$echo = $stdout->writeln(...);

$config =
    (new ConfigBuilder())
        ->inSynchronousMode()
//        ->withFrames(FrameCollection::create(...FramePattern::DIAMOND))
        ->withFinalMessage('Done!' . PHP_EOL)
        ->build()
;

$spinner = WSpinnerFactory::create($config);

$echo('Started...');
$echo('But may be interrupted...');

if (defined('SIGINT')) { // check for ext-pcntl
    pcntl_async_signals(true);
    pcntl_signal(
        SIGINT,
        static function () use ($spinner): never {
            $spinner->interrupt();
            $spinner->finalize();
            exit;
        }
    );
    $echo('Ctrl+C to interrupt...');
}

$spinner->initialize();
for ($i = 0; $i < 100; $i++) {
    if (100 > random_int(0, 100000)) {
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
        $spinner->wrap($echo, 'Yay! 50% done!');
    }
    if ($i === 60) {
        $spinner->progress(0.6);
        $spinner->message('0123');
    }
    if ($i === 80) {
        $spinner->progress(0.8);
    }
    if ($i === 90) {
        $spinner->wrap($echo, 'Almost done...');
    }
    $spinner->spin();
    usleep(100000);
}
$spinner->finalize();

dump($spinner);

echo PHP_EOL;

