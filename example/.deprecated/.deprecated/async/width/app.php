<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Spinner\StaticFacade;

require_once __DIR__ . '/../bootstrap.async.php';

$defaults = StaticDefaultsFactory::get();

$terminal = $defaults->getTerminalSettings();

$terminal->overrideColorMode(StylingMethodOption::NONE);
$terminal->overrideWidth(80);

$output = new StreamBufferedOutput(STDOUT);

$loop = StaticFacade::getLoop();

$output->writeln(
    sprintf(
        'Terminal width: %d, color mode: %s',
        $terminal->getWidth(),
        $terminal->getStyleMode()->name
    )
);
