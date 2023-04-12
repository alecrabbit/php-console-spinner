<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults\Override;

use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;

final class SignalProcessingProbeStub implements ISignalProcessingProbe
{
    public static function isAvailable(): bool
    {
        return true;
    }
}
