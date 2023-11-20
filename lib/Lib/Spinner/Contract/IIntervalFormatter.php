<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;

interface IIntervalFormatter
{
    /**
     * Extracts interval from IHasInterval and formats it.
     */
    public function format(IHasInterval $object): string;
}
