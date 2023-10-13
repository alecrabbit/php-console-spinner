<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;
use RuntimeException;

class PositiveSignalProcessingProbeOverride implements ISignalProcessingProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        // TODO: Implement getCreatorClass() method.
        throw new RuntimeException('Not implemented.');
    }
}
