<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodOptionCreator;

final class StylingMethodOptionCreator implements IStylingMethodOptionCreator
{
    public static function create(): StylingMethodOption
    {
        return StylingMethodOption::AUTO;
    }
}
