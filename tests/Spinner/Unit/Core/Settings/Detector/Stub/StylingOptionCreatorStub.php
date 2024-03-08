<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingOptionCreator;

class StylingOptionCreatorStub implements IStylingOptionCreator
{

    public function create(): StylingOption
    {
        return StylingOption::ANSI24;
    }
}
