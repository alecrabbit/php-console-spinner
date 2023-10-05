<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;

class SignalProcessingProbe implements ISignalProcessingProbe
{
    private const SIGNAL_PROCESSING_EXTENSION = 'pcntl';

    public static function isSupported(): bool
    {
        return extension_loaded(self::SIGNAL_PROCESSING_EXTENSION);
    }
}
