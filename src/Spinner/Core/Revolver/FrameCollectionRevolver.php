<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;

final class FrameCollectionRevolver extends ARevolver implements IFrameCollectionRevolver
{
    private readonly int $toleranceValue;
    private readonly float $intervalValue;
    private float $diff;

    public function __construct(
        private readonly IFrameCollection $frameCollection,
        IInterval $interval,
        private readonly ITolerance $tolerance = new Tolerance(),
    ) {
        parent::__construct($interval);
        $this->toleranceValue = $this->tolerance->toMilliseconds();
        $this->intervalValue = $interval->toMilliseconds();
        $this->diff = $this->intervalValue;
    }

    public function getFrame(?float $dt = null): ISequenceFrame
    {
        if ($this->shouldUpdate($dt)) {
            $this->next($dt);
        }
        return $this->current();
    }

    private function shouldUpdate(?float $dt = null): bool
    {
        if ($dt === null || $this->intervalValue <= ($dt + $this->toleranceValue) || $this->diff <= 0) {
            $this->diff = $this->intervalValue;
            return true;
        }
        $this->diff -= $dt;
        return false;
    }

    private function next(?float $dt = null): void
    {
        $this->frameCollection->next();
    }

    private function current(): ISequenceFrame
    {
        return $this->frameCollection->current();
    }
}
