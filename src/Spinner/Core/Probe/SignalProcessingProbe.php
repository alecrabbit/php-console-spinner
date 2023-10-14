<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;

final class SignalProcessingProbe implements ISignalProcessingProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        return SignalHandlersOptionCreator::class;
    }
}
