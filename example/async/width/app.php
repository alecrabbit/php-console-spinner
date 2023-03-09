<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Factory;
use Symfony\Component\Console\Terminal;

require_once __DIR__ . '/../bootstrap.async.php';

$spinner = Factory::createSpinner();
$loop = Factory::getLoop();
$output = new StreamOutput(STDOUT);

$terminal = new Terminal();

$loop->repeat(
    1,
    static function () use ($spinner, $output, $terminal) {
        $spinner->wrap(
            static function () use ($output, $terminal) {
                $output->writeln(
                    sprintf(
                        'Terminal width: %d, color mode: %s',
                        $terminal->getWidth(),
                        $terminal::getColorMode()->name
                    )
                );
            },
        );
    },
);
