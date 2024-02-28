<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IUpdateChecker;

final class UpdateChecker implements IUpdateChecker
{
    private float $diff;

    public function __construct(
        private readonly float $intervalValue,
        private readonly int $toleranceValue,
    ) {
        $this->diff = $this->intervalValue;
    }

    public function isDue(?float $dt = null): bool
    {
        if ($dt === null || $this->intervalValue <= ($dt + $this->toleranceValue) || $this->diff <= 0) {
            $this->diff = $this->intervalValue;
            return true;
        }
        $this->diff -= $dt;
        return false;
    }
}
