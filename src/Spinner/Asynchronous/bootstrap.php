<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\ContainerFactory;

// @codeCoverageIgnoreStart
$container = ContainerFactory::getContainer();

$container->add(
    ILoopProbeFactory::class,
    static function () use ($container): ILoopProbeFactory {
        return
            new LoopProbeFactory(
                $container,
                new ArrayObject([
                    RevoltLoopProbe::class,
                    ReactLoopProbe::class,
                ]),
            );
    },
);
// @codeCoverageIgnoreEnd
