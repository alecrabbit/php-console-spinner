<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

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
        // TODO: Implement getCreatorClass() method.
        throw new RuntimeException('Not implemented.');
    }
}
