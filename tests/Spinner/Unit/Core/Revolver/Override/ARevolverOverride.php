<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Revolver\Override;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;

final class ARevolverOverride extends ARevolver
{
    public function __construct(
        private IFrame $frame,
        IInterval $interval,
        ITolerance $tolerance,
    ) {
        parent::__construct($interval, $tolerance);
    }

    private function next(?float $dt = null): void
    {
        {
            // simulating frame update
            $this->frame->getSequence();
            $this->frame->getWidth();
        }
    }

    private function current(): IFrame
    {
        return $this->frame;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        if ($this->shouldUpdate($dt)) {
            $this->next($dt);
        }
        return $this->current();
    }

    private function shouldUpdate(?float $dt = null): bool
    {
        if ($dt === null || $this->intervalValue <= ($dt + $this->deltaTolerance) || $this->diff <= 0) {
            $this->diff = $this->intervalValue;
            return true;
        }
        $this->diff -= $dt;
        return false;
    }
}
