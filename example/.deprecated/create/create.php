<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.php';

$spinner = SpinnerFactory::create();

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...);

$max = 200;
$intervalObject = $spinner->getInterval();
$interval = (int)$intervalObject->toMicroseconds();

dump($spinner, $interval);

for ($i = 0; $i < $max; $i++) {
    $start = hrtime(true);
    $spinner->spin();
    $t[] = hrtime(true) - $start;
    usleep($interval);
    if ($i > 10 && $i % 20 === 0) {
        $spinner->wrap(
            $echo,
            sprintf(
                '%s▕ %s▕ %s▕ %s▕',
                '(STDOUT)',
                (new DateTimeImmutable())->format('Y-m-d H:i:s.u'),
                sprintf(
                    'Time Avg: %sμs',
                    number_format((array_sum($t) / count($t)) / 1000, 3),
                ),
                sprintf(
                    'Memory Real: %sK Peak: %sK',
                    number_format(memory_get_usage(true) / 1024),
                    number_format(memory_get_peak_usage(true) / 1024,),
                ),
            ),
        );
    }
}
$spinner->finalize();
