<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodOptionCreator;

class StylingMethodOptionCreatorOverride implements IStylingMethodOptionCreator
{

    public static function create(): StylingMethodOption
    {
        return StylingMethodOption::ANSI24;
    }
}
