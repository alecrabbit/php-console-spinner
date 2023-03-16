<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;

require_once __DIR__ . '/../bootstrap.async.php';

$defaults = DefaultsFactory::get();

$terminal = $defaults->getTerminalSettings();

$terminal->setColorMode(ColorMode::NONE);
$terminal->setWidth(80);

$output = new StreamOutput(STDOUT);

$loop = SpinnerFactory::getLoop();

$output->writeln(
    sprintf(
        'Terminal width: %d, color mode: %s',
        $terminal->getWidth(),
        $terminal->getColorMode()->name
    )
);


