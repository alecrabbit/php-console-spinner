<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

use AlecRabbit\Spinner\Contract\ICreator;
use AlecRabbit\Spinner\Contract\Option\StylingOption;

interface IStylingOptionCreator extends ICreator
{
    public function create(): StylingOption;
}
