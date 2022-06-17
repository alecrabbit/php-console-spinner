<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Core\Wiggler;

final class Cycle
{
    private readonly int $cycleNumber;
    private int $currentCycle;

    public function __construct(int $cycles,)
    {
        $this->cycleNumber = $cycles - 1;
    }

    public function render(): bool
    {
        if (0 === $this->currentCycle) {
            $this->currentCycle = $this->cycleNumber;
            return true;
        }
        $this->currentCycle--;
        return false;
    }

}
