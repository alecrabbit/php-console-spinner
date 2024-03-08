<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Contract\Option\StylingModeOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingModeOptionCreator;

class StylingModeOptionCreatorStub implements IStylingModeOptionCreator
{

    public function create(): StylingModeOption
    {
        return StylingModeOption::ANSI24;
    }
}
