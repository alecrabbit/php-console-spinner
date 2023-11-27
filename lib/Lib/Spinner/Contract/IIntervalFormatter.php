<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;

interface IIntervalFormatter
{
    /**
     * Formats interval contained in object.
     */
    public function format(IHasInterval $object): string;
}
