<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ISignalProcessingSupportDetector
{
    /**
     * @throws InvalidArgumentException
     */
    public function isSupported(): bool;
}
