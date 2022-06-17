<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Wiggler\Contract\ICycle;

final class Cycle implements ICycle
{
    private readonly int $cycleNumber;
    private int $currentCycle = 0;

    public function __construct(int $cycles)
    {
        $this->cycleNumber = $cycles - 1;
    }

    public function completed(): bool
    {
        if (0 === $this->currentCycle) {
            $this->currentCycle = $this->cycleNumber;
            return true;
        }
        $this->currentCycle--;
        return false;
    }

}
