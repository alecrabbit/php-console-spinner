<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

use AlecRabbit\Spinner\Contract\ICreator;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;

interface IStylingMethodOptionCreator extends ICreator
{
    public static function create(): StylingMethodOption;
}
