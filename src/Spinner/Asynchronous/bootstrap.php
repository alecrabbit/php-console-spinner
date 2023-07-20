<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Probes;

// @codeCoverageIgnoreStart

Probes::register(
    RevoltLoopProbe::class,
    ReactLoopProbe::class
);

// @codeCoverageIgnoreEnd
