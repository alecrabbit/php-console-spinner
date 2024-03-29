<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingOptionCreator;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;

final class SignalHandlingProbe implements ISignalHandlingProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    /**
     * @return class-string<ISignalHandlingOptionCreator>
     */
    public static function getCreatorClass(): string
    {
        return SignalHandlingOptionCreator::class;
    }
}
