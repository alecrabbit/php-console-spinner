<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingOptionCreator;

final readonly class StylingOptionCreator implements IStylingOptionCreator
{
    public function create(): StylingOption
    {
        return StylingOption::AUTO;
    }
}
