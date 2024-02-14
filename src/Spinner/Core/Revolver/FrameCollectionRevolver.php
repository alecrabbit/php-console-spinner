<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;

final class FrameCollectionRevolver extends ARevolver implements IFrameCollectionRevolver
{
    public function __construct(
        protected IFrameCollection $frameCollection,
        IInterval $interval,
        ITolerance $tolerance,
    ) {
        parent::__construct($interval, $tolerance);
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

    private function next(?float $dt = null): void
    {
        $this->frameCollection->next();
    }

    private function current(): IFrame
    {
        return $this->frameCollection->current();
    }
}
