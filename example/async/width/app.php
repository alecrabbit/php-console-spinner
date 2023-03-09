<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

require_once __DIR__ . '/../bootstrap.async.php';

$defaults = DefaultsFactory::create();
$output = new StreamOutput(STDOUT);

$loop = Factory::getLoop();

$output->writeln(
    sprintf(
        'Terminal width: %d, color mode: %s',
        $defaults->getTerminal()->getWidth()
    )
);


