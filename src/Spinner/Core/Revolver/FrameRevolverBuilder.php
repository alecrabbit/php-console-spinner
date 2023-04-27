<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

final class FrameRevolverBuilder implements IFrameRevolverBuilder
{
    private ?IFrameCollection $frames = null;
    private ?IInterval $interval = null;
    private ?int $tolerance = null;

    public function build(): IFrameRevolver
    {
        $this->validate();

        return
            new FrameCollectionRevolver(
                $this->frames,
                $this->interval,
                $this->tolerance,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->frames === null => throw new LogicException('Frame collection is not set.'),
            $this->interval === null => throw new LogicException('Interval is not set.'),
            $this->tolerance === null => throw new LogicException('Tolerance is not set.'),
            default => null,
        };
    }

    public function withFrameCollection(IFrameCollection $frames): IFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    public function withInterval(IInterval $interval): IFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function withTolerance(int $tolerance): IFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->tolerance = $tolerance;
        return $clone;
    }
}
