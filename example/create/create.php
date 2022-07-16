<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...);

$config =
    (new ConfigBuilder())
        ->inSynchronousMode()
        ->withCursor()
        ->build()
;

$spinner = SpinnerFactory::create($config);

$t = [];

$interval = (int)$spinner->getInterval()->toMicroseconds();

$spinner->initialize();

dump($interval);

for ($i = 0; $i < 200; $i++) {
    $start = hrtime(true);
    $spinner->spin();
    $t[] = hrtime(true) - $start;
    usleep($interval);
    if ($i > 10 && $i % 20 === 0) {
        $spinner->wrap(
            $echo,
            sprintf(
                'Average cycle execution time: %sμs',
                number_format((array_sum($t) / count($t)) / 1000, 3)
            )
        );
    }
    if ($i > 30 && $i % 25 === 0) {
        $spinner->progress('99.9%');
//        dump($spinner);
    }
}

$spinner->finalize();

