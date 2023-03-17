<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Extras\Terminal\SymfonyTerminalProbe;

// @codeCoverageIgnoreStart

DefaultsFactory::addProbe(SymfonyTerminalProbe::class);

// @codeCoverageIgnoreEnd