<?php

declare(strict_types=1);

// 14.04.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;

use function extension_loaded;

final class SignalProcessingProbe implements ISignalProcessingProbe
{
    private const SIGNAL_PROCESSING_EXTENSION = 'pcntl';

    public function isAvailable(): bool
    {
        return extension_loaded(self::SIGNAL_PROCESSING_EXTENSION);
    }
}
