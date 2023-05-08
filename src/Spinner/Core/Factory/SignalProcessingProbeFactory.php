<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\SignalProcessingProbe;

final class SignalProcessingProbeFactory implements Contract\ISignalProcessingProbeFactory
{
    public function getProbe(): ISignalProcessingProbe
    {
        return new SignalProcessingProbe();
    }
}
