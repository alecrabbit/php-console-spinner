<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodOptionCreator;

final readonly class StylingMethodOptionCreator implements IStylingMethodOptionCreator
{
    public function create(): StylingMethodOption
    {
        return StylingMethodOption::ANSI8;
    }
}
