<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Probe\ColorSupportProbe;
use AlecRabbit\Spinner\Core\Probe\SignalProcessingProbe;
use AlecRabbit\Spinner\Probes;

Probes::register(
    SignalProcessingProbe::class,
    ColorSupportProbe::class,
);
