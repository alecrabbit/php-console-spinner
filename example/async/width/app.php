<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Factory;
use Symfony\Component\Console\Terminal;

require_once __DIR__ . '/../bootstrap.async.php';


$spinner = Factory::createSpinner();
$loop = Factory::getLoop();
$output = new StreamOutput(STDOUT);

$loop->repeat(
    1,
    static function () use ($spinner, $output) {
        $spinner->wrap(
            static function () use ($output) {
                $terminal = new Terminal();
                $output->writeln(
                    sprintf(
                        'Terminal width: %d',
                        $terminal->getWidth()
                    )
                );
                $output->writeln(
                    sprintf(
                        'Terminal color mode: %s',
                        $terminal::getColorMode()->name
                    )
                );
            },
        );
    },
);
