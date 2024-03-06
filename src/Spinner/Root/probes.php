<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Root;

use AlecRabbit\Spinner\Core\Probe\SignalHandlingProbe;
use AlecRabbit\Spinner\Core\Probe\StylingMethodProbe;
use AlecRabbit\Spinner\Core\Probes;

// @codeCoverageIgnoreStart

Probes::register(
    SignalHandlingProbe::class,
    StylingMethodProbe::class,
);

// @codeCoverageIgnoreEnd
