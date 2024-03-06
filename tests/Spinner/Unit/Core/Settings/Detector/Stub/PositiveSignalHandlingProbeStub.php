<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;

class PositiveSignalHandlingProbeStub implements ISignalHandlingProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        return SignalHandlingOptionCreatorStub::class;
    }
}
