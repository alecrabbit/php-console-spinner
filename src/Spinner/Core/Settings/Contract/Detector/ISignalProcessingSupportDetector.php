<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ISignalProcessingSupportDetector extends IDetector
{
    /**
     * @throws InvalidArgumentException
     */
    public function isSupported(): bool;

    public function getSupportValue(): SignalHandlersOption;
}
