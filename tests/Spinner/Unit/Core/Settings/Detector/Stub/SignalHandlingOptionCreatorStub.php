<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingOptionCreator;

class SignalHandlingOptionCreatorStub implements ISignalHandlingOptionCreator
{
    public function create(): SignalHandlingOption
    {
        return SignalHandlingOption::ENABLED;
    }
}
