<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Probe;

// @codeCoverageIgnoreStart

Probe::register(RevoltLoopProbe::class);
Probe::register(ReactLoopProbe::class);

// TODO (2023-07-20 17:00) [Alec Rabbit]: HIDE LOGIC BELOW
$definitions = DefinitionRegistry::getInstance();

$definitions->bind(
    ILoopProbeFactory::class,
    static function (): ILoopProbeFactory {
        return
            new LoopProbeFactory(getLoopProbes());
    },
);

/**
 * @return Traversable<class-string<ILoopProbe>>
 */
function getLoopProbes(): Traversable
{
    foreach (Probe::load() as $probe) {
        if (is_subclass_of($probe, ILoopProbe::class)) {
            yield $probe;
        }
    }
}

// @codeCoverageIgnoreEnd
