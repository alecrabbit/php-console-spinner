<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ILoopAvailabilityDetector
{
    /**
     * @throws InvalidArgumentException
     */
    public function loopIsAvailable(): bool;
}
