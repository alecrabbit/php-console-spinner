<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Loop\LoopManager;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\ILoopManager;

// @codeCoverageIgnoreStart
$container = ContainerFactory::getContainer();

$container->replace(
    ILoopManager::class,
    static function () use ($container): ILoopManager {
        return
            new LoopManager(
                $container,
                new ArrayObject([
                    ReactLoopProbe::class,
                    RevoltLoopProbe::class,
                ]),
            );
    },
);
// @codeCoverageIgnoreEnd
