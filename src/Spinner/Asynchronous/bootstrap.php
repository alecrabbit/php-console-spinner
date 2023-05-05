<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;

// @codeCoverageIgnoreStart

$definitions = DefinitionRegistry::getInstance();

$definitions->bind(
    ILoopProbeFactory::class,
    static function (): ILoopProbeFactory {
        return new LoopProbeFactory(probes());
    },
);

/**
 * @return Traversable<class-string<ILoopProbe>>
 */
function probes(): Traversable
{
    yield from [
        RevoltLoopProbe::class,
        ReactLoopProbe::class,
    ];
}

// @codeCoverageIgnoreEnd
