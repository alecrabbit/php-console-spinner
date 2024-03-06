<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Probes;

// @codeCoverageIgnoreStart

Probes::register(
    ReactLoopProbe::class,
    RevoltLoopProbe::class,
);

// @codeCoverageIgnoreEnd
