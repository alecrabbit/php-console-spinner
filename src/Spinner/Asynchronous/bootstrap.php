<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe;
use AlecRabbit\Spinner\Probes;

// @codeCoverageIgnoreStart

Probes::register(
    RevoltLoopProbe::class,
    ReactLoopProbe::class
);

// @codeCoverageIgnoreEnd
