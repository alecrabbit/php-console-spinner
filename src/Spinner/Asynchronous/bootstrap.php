<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Facade;

// @codeCoverageIgnoreStart
$container = Facade::getContainer();

$container->replace(
    ILoopProbeFactory::class,
    static function (): ILoopProbeFactory {
        return
            new LoopProbeFactory(
                new ArrayObject([
                    RevoltLoopProbe::class,
                    ReactLoopProbe::class,
                ]),
            );
    },
);
// @codeCoverageIgnoreEnd
