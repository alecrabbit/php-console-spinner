<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Probe\SignalHandlingProbe;
use AlecRabbit\Spinner\Core\Probe\StylingMethodProbe;
use AlecRabbit\Spinner\Probes;

// @codeCoverageIgnoreStart

Probes::register(
    SignalHandlingProbe::class,
    StylingMethodProbe::class,
);

// @codeCoverageIgnoreEnd
