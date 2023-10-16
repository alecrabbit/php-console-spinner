<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingOptionCreator;

class SignalHandlingOptionCreatorOverride implements ISignalHandlingOptionCreator
{
    public function create(): SignalHandlingOption
    {
        return SignalHandlingOption::ENABLED;
    }
}
