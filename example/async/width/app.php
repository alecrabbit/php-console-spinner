<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\ColorMode;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

require_once __DIR__ . '/../bootstrap.async.php';

$defaults = DefaultsFactory::create();

$terminal = $defaults->getTerminal();

$terminal->setColorMode(ColorMode::NONE);
$terminal->setWidth(80);

$output = new StreamOutput(STDOUT);

$loop = Factory::getLoop();

$output->writeln(
    sprintf(
        'Terminal width: %d, color mode: %s',
        $terminal->getWidth(),
        $terminal->getColorMode()->name
    )
);


