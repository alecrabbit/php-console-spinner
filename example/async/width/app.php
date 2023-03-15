<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Factory;

require_once __DIR__ . '/../bootstrap.async.php';

$defaults = DefaultsFactory::get();

$terminal = $defaults->getTerminalSettings();

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


