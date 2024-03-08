<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\StylingModeOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingModeOptionCreator;

final readonly class StylingModeOptionCreator implements IStylingModeOptionCreator
{
    public function create(): StylingModeOption
    {
        return StylingModeOption::AUTO;
    }
}
