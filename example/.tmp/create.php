<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\SpinnerFactory;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...);

$config =
    (new ConfigBuilder())
        ->withCursor()
        ->build()
;

$spinner = SpinnerFactory::create($config);

dump($spinner);

$t = [];

$interval = 100000; // $spinner->getInterval()->toMicroseconds();

$spinner->initialize();

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
}

$spinner->finalize();

