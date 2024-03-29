<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;
use RuntimeException;

class NegativeSignalHandlingProbeOverride implements ISignalHandlingProbe
{
    public static function isSupported(): bool
    {
        return false;
    }

    public static function getCreatorClass(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
