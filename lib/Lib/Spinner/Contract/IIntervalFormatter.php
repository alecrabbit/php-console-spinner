<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

use AlecRabbit\Spinner\Contract\IInterval;

interface IIntervalFormatter
{
    /**
     * Formats interval contained in object.
     */
    public function format(IInterval $interval): string;
}
