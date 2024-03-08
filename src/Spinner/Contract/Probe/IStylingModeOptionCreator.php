<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

use AlecRabbit\Spinner\Contract\ICreator;
use AlecRabbit\Spinner\Contract\Option\StylingModeOption;

interface IStylingModeOptionCreator extends ICreator
{
    public function create(): StylingModeOption;
}
