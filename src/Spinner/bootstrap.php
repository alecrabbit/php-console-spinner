<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Core\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;

$container = ContainerFactory::createContainer();

$container->add(
    ILoopProbeFactory::class,
    static function () use ($container): ILoopProbeFactory {
        return
            new LoopProbeFactory(
                $container,
                new ArrayObject([
                ]),
            );
    },
);
