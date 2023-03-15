<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

abstract class ARevolver implements IRevolver
{
    protected const TOLERANCE = 5; // ms
    protected float $intervalValue;
    protected float $differential;

    protected IInterval $interval;
    protected int $tolerance;

    public function __construct(
        IInterval $interval,
    ) {
        $this->setInterval($interval);
        $this->tolerance = static::TOLERANCE;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function setInterval(IInterval $interval): void
    {
        $this->interval = $interval->smallest($this->interval ?? null);
        $this->intervalValue = $interval->toMilliseconds();
        $this->differential = $this->intervalValue;
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->shouldUpdate($dt)) {
            $this->next($dt);
        }
        return $this->current();
    }

    protected function shouldUpdate(float $dt = null): bool
    {
        if (null === $dt || $this->intervalValue <= ($dt + $this->tolerance) || $this->differential <= 0) {
            $this->differential = $this->intervalValue;
            return true;
        }
        $this->differential -= $dt;
        return false;
    }

    abstract protected function next(float $dt = null): void;

    abstract protected function current(): IFrame;
}
