<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\IWiggler;

abstract class AWiggler implements IWiggler
{
    public function getSequence(float|int|null $interval = null): string
    {
        return '';
    }

    public function getWidth(): int
    {
        return 0;
    }
}
