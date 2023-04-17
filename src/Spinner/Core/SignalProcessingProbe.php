<?php

declare(strict_types=1);

// 14.04.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;

final class SignalProcessingProbe implements ISignalProcessingProbe
{
    public function __construct()
    {
    }

    public static function isAvailable(): bool
    {
        return true; // FIXME (2023-04-14 15:48) [Alec Rabbit]: IT IS A STUB!
    }
}
