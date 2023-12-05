<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class FrameCollectionRevolverBuilder implements IFrameCollectionRevolverBuilder
{
    private ?IFrameCollection $frames = null;
    private ?IInterval $interval = null;
    private ?ITolerance $tolerance = null;

    public function build(): IFrameRevolver
    {
        $this->validate();

        return new FrameCollectionRevolver(
            $this->frames,
            $this->interval,
            $this->tolerance,
        );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->frames === null => throw new LogicException('Frame collection is not set.'),
            $this->interval === null => throw new LogicException('Interval is not set.'),
            $this->tolerance === null => throw new LogicException('Tolerance is not set.'),
            default => null,
        };
    }

    public function withFrameCollection(IFrameCollection $frames): IFrameCollectionRevolverBuilder
    {
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    public function withInterval(IInterval $interval): IFrameCollectionRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function withTolerance(ITolerance $tolerance): IFrameCollectionRevolverBuilder
    {
        $clone = clone $this;
        $clone->tolerance = $tolerance;
        return $clone;
    }
}
