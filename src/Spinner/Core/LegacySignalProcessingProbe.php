<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;

use function extension_loaded;

/**
 * @deprecated Will be removed
 */
final class LegacySignalProcessingProbe implements ILegacySignalProcessingLegacyProbe
{
    private const SIGNAL_PROCESSING_EXTENSION = 'pcntl';

    public function isAvailable(): bool
    {
        return extension_loaded(self::SIGNAL_PROCESSING_EXTENSION);
    }
}
