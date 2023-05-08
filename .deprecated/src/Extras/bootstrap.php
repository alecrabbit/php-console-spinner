<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
use AlecRabbit\Spinner\Core\Factory\TerminalProbeFactory;
use AlecRabbit\Spinner\Extras\Factory\HexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Terminal\SymfonyTerminalProbe;
use AlecRabbit\Spinner\Facade;

// @codeCoverageIgnoreStart

Facade::useService(
    IHexColorToAnsiCodeConverterFactory::class,
    HexColorToAnsiCodeConverterFactory::class,
);
Facade::useService(
    ITerminalProbeFactory::class,
    static function (): ITerminalProbeFactory {
        return new TerminalProbeFactory(
            new ArrayObject([
                SymfonyTerminalProbe::class,
            ]),
        );
    },
);
// @codeCoverageIgnoreEnd
