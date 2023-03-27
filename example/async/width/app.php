<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$defaults = DefaultsFactory::get();

$terminal = $defaults->getTerminalSettings();

$terminal->overrideColorMode(StyleMode::NONE);
$terminal->overrideWidth(80);

$output = new StreamOutput(STDOUT);

$loop = Facade::getLoop();

$output->writeln(
    sprintf(
        'Terminal width: %d, color mode: %s',
        $terminal->getWidth(),
        $terminal->getStyleMode()->name
    )
);


