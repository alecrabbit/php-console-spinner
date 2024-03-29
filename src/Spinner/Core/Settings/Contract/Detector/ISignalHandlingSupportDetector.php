<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;

interface ISignalHandlingSupportDetector extends IDetector
{
    public function getSupportValue(): SignalHandlingOption;
}
